import makeWASocket, { useMultiFileAuthState, DisconnectReason, fetchLatestBaileysVersion } from '@whiskeysockets/baileys';
import pino from 'pino';
import qrcode from 'qrcode-terminal';
import fs from 'fs';
import http from 'http';
import path from 'path';

// ========== CONFIG ==========
const LARAVEL_API = process.env.LARAVEL_API || 'http://127.0.0.1:8000/api';
const HTTP_PORT = process.env.BOT_PORT || 3002;
const AUTH_DIR = './auth_state';

const logger = pino({ level: 'silent' });

let sock = null;
let currentQR = null;
let connectionStatus = 'disconnected';

// ========== WHATSAPP BOT ==========
async function startBot() {
    const { state, saveCreds } = await useMultiFileAuthState(AUTH_DIR);
    const { version } = await fetchLatestBaileysVersion();

    sock = makeWASocket({
        version,
        auth: state,
        logger,
        printQRInTerminal: false,
        browser: ['INSAM Bot', 'Chrome', '1.0.0'],
    });

    // Connection events
    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (qr) {
            currentQR = qr;
            connectionStatus = 'qr_ready';
            console.log('\n=== QR Code disponible ===');
            console.log('Scannez depuis le dashboard admin ou dans le terminal:');
            qrcode.generate(qr, { small: true });
        }

        if (connection === 'open') {
            currentQR = null;
            connectionStatus = 'connected';
            console.log('\n✅ Bot WhatsApp connecte !');
        }

        if (connection === 'close') {
            const reason = lastDisconnect?.error?.output?.statusCode;
            connectionStatus = 'disconnected';
            currentQR = null;

            if (reason !== DisconnectReason.loggedOut) {
                console.log('Reconnexion...');
                setTimeout(startBot, 3000);
            } else {
                console.log('Deconnecte. Suppression session...');
                if (fs.existsSync(AUTH_DIR)) {
                    fs.rmSync(AUTH_DIR, { recursive: true });
                }
                setTimeout(startBot, 3000);
            }
        }
    });

    sock.ev.on('creds.update', saveCreds);

    // Message handler
    sock.ev.on('messages.upsert', async ({ messages, type }) => {
        if (type !== 'notify') return;

        for (const msg of messages) {
            if (msg.key.fromMe) continue;
            if (!msg.message) continue;

            const jid = msg.key.remoteJid;
            // Skip group messages
            if (jid.endsWith('@g.us')) continue;

            const text = msg.message.conversation
                || msg.message.extendedTextMessage?.text
                || msg.message.imageMessage?.caption
                || '';

            if (!text.trim()) continue;

            console.log(`📩 Message de ${jid}: ${text.substring(0, 50)}...`);

            // Get AI response from Laravel API
            try {
                const aiResponse = await getAIResponse(text, jid);
                await sock.sendMessage(jid, { text: aiResponse });
                console.log(`✅ Reponse envoyee a ${jid}`);
            } catch (err) {
                console.error('Erreur reponse IA:', err.message);
                await sock.sendMessage(jid, {
                    text: '⚠️ Desole, je rencontre un probleme technique. Reessayez dans quelques instants.'
                });
            }
        }
    });
}

// ========== AI RESPONSE VIA LARAVEL ==========
async function getAIResponse(message, whatsappJid) {
    // Call the Laravel whatsapp-chat endpoint
    const response = await fetch(`${LARAVEL_API}/whatsapp/chat`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            message: message,
            whatsapp_jid: whatsappJid,
        }),
    });

    if (!response.ok) {
        throw new Error(`API error: ${response.status}`);
    }

    const data = await response.json();
    return data.reponse || 'Desole, je n\'ai pas pu generer une reponse.';
}

// ========== HTTP SERVER (for admin dashboard) ==========
const server = http.createServer((req, res) => {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
    res.setHeader('Content-Type', 'application/json');

    if (req.method === 'OPTIONS') {
        res.writeHead(200);
        return res.end();
    }

    // GET /status
    if (req.url === '/status' && req.method === 'GET') {
        return res.end(JSON.stringify({
            status: connectionStatus,
            qr: currentQR,
            phone: sock?.user?.id?.split(':')[0] || null,
            name: sock?.user?.name || null,
        }));
    }

    // POST /logout
    if (req.url === '/logout' && req.method === 'POST') {
        if (sock) {
            sock.logout().catch(() => {});
        }
        connectionStatus = 'disconnected';
        currentQR = null;
        return res.end(JSON.stringify({ message: 'Deconnecte' }));
    }

    // POST /restart
    if (req.url === '/restart' && req.method === 'POST') {
        if (fs.existsSync(AUTH_DIR)) {
            fs.rmSync(AUTH_DIR, { recursive: true });
        }
        connectionStatus = 'disconnected';
        currentQR = null;
        if (sock) {
            sock.end(undefined);
        }
        setTimeout(startBot, 1000);
        return res.end(JSON.stringify({ message: 'Redemarrage...' }));
    }

    res.writeHead(404);
    res.end(JSON.stringify({ error: 'Not found' }));
});

server.listen(HTTP_PORT, () => {
    console.log(`🤖 INSAM WhatsApp Bot API sur http://localhost:${HTTP_PORT}`);
    startBot();
});
