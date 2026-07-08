<template>
  <div class="chat-page">
    <div class="chat-sidebar">
      <div class="chat-sidebar-head">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <span>Assistant IA INSAM</span>
      </div>
      <div class="chat-sidebar-info">
        <div class="info-item">
          <div class="info-dot green"></div>
          <span>IA en ligne</span>
        </div>
        <p class="chat-sidebar-desc">Posez vos questions sur les cours, revisions, examens ou orientation. L'IA utilise la base de connaissances INSAM pour vous repondre.</p>
      </div>
      <div class="chat-suggestions">
        <div class="suggest-label">Suggestions</div>
        <button v-for="s in suggestions" :key="s" @click="useSuggestion(s)" class="suggest-btn">{{ s }}</button>
      </div>
    </div>

    <div class="chat-main">
      <div class="chat-messages" ref="messagesEl">
        <div v-if="messages.length === 0" class="chat-empty">
          <div class="chat-empty-icon">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </div>
          <h3>Bienvenue sur l'Assistant IA</h3>
          <p>Posez une question pour commencer la conversation</p>
        </div>
        <div v-for="msg in messages" :key="msg.id" class="chat-message" :class="msg.type">
          <div class="chat-avatar">{{ msg.type === 'user' ? 'Moi' : 'IA' }}</div>
          <div class="chat-bubble">{{ msg.text }}</div>
        </div>
        <div v-if="loading" class="chat-message bot">
          <div class="chat-avatar">IA</div>
          <div class="chat-bubble typing">
            <span class="dot"></span><span class="dot"></span><span class="dot"></span>
          </div>
        </div>
      </div>
      <div class="chat-input-bar">
        <input v-model="input" @keyup.enter="send" placeholder="Ecrivez votre question ici..." :disabled="loading" />
        <button @click="send" class="send-btn" :disabled="loading || !input.trim()">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick, onMounted } from 'vue';
import api from '../api';

const messages = ref([]);
const input = ref('');
const loading = ref(false);
const messagesEl = ref(null);

const suggestions = [
  'Explique-moi les bases du marketing',
  'Comment bien reviser pour un examen ?',
  'Quelles sont les etapes de la gestion de projet ?',
  'Aide-moi a comprendre la comptabilite generale',
];

function scrollDown() {
  nextTick(() => { if (messagesEl.value) messagesEl.value.scrollTop = messagesEl.value.scrollHeight; });
}

function useSuggestion(text) {
  input.value = text;
  send();
}

async function send() {
  if (!input.value.trim() || loading.value) return;
  const text = input.value;
  input.value = '';
  messages.value.push({ id: Date.now(), type: 'user', text });
  scrollDown();
  loading.value = true;
  try {
    const { data } = await api.post('/chat', { message: text });
    messages.value.push({ id: data.reponse.id, type: 'bot', text: data.reponse.contenu });
  } catch {
    messages.value.push({ id: Date.now(), type: 'bot', text: 'Erreur de connexion. Reessayez.' });
  }
  loading.value = false;
  scrollDown();
}

onMounted(async () => {
  try {
    const { data } = await api.get('/chat/history');
    data.reverse().forEach(q => {
      messages.value.push({ id: q.id, type: 'user', text: q.contenu });
      if (q.reponse) messages.value.push({ id: q.reponse.id, type: 'bot', text: q.reponse.contenu });
    });
    scrollDown();
  } catch {}
});
</script>

<style scoped>
.chat-page { display: flex; height: calc(100vh - 100px); margin: -2rem; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); }

.chat-sidebar { width: 280px; background: #fafbfd; border-right: 1px solid var(--border); display: flex; flex-direction: column; flex-shrink: 0; }
.chat-sidebar-head { display: flex; align-items: center; gap: 10px; padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border); font-weight: 600; font-size: 0.95rem; color: var(--text); }
.chat-sidebar-info { padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border); }
.info-item { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #059669; font-weight: 500; margin-bottom: 0.8rem; }
.info-dot { width: 8px; height: 8px; border-radius: 50%; }
.info-dot.green { background: #10b981; box-shadow: 0 0 6px rgba(16,185,129,0.5); }
.chat-sidebar-desc { font-size: 0.82rem; color: var(--text-light); line-height: 1.5; }

.chat-suggestions { padding: 1.2rem 1.5rem; flex: 1; }
.suggest-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; font-weight: 600; margin-bottom: 0.8rem; }
.suggest-btn {
  display: block; width: 100%; text-align: left; background: #fff; border: 1px solid var(--border);
  padding: 0.7rem 0.9rem; border-radius: 8px; font-size: 0.82rem; color: var(--text);
  cursor: pointer; margin-bottom: 0.5rem; transition: all 0.2s; line-height: 1.4;
}
.suggest-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }

.chat-main { flex: 1; display: flex; flex-direction: column; }
.chat-messages { flex: 1; overflow-y: auto; padding: 1.5rem; }
.chat-empty { text-align: center; padding: 4rem 2rem; }
.chat-empty-icon { margin-bottom: 1rem; }
.chat-empty h3 { font-size: 1.1rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.chat-empty p { font-size: 0.88rem; color: var(--text-light); }

.chat-message { margin-bottom: 1.2rem; display: flex; gap: 10px; align-items: flex-start; }
.chat-message.user { flex-direction: row-reverse; }
.chat-bubble { max-width: 70%; padding: 0.9rem 1.1rem; border-radius: 16px; font-size: 0.9rem; line-height: 1.6; white-space: pre-wrap; }
.chat-message.user .chat-bubble { background: var(--primary); color: #fff; border-bottom-right-radius: 4px; }
.chat-message.bot .chat-bubble { background: #f8fafc; border: 1px solid var(--border); border-bottom-left-radius: 4px; }
.chat-avatar { width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 700; flex-shrink: 0; }
.chat-message.user .chat-avatar { background: var(--primary-dark); color: #fff; }
.chat-message.bot .chat-avatar { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }

.typing { display: flex; gap: 4px; align-items: center; padding: 1rem 1.2rem !important; }
.dot { width: 8px; height: 8px; border-radius: 50%; background: #94a3b8; animation: bounce 1.4s infinite; }
.dot:nth-child(2) { animation-delay: 0.2s; }
.dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes bounce { 0%,60%,100% { transform: translateY(0); } 30% { transform: translateY(-6px); } }

.chat-input-bar { display: flex; gap: 8px; padding: 1rem 1.5rem; border-top: 1px solid var(--border); background: #fafbfd; }
.chat-input-bar input { flex: 1; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: 10px; font-size: 0.9rem; outline: none; background: #fff; }
.chat-input-bar input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
.send-btn {
  width: 44px; height: 44px; border-radius: 10px; background: var(--primary); color: #fff;
  border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s;
}
.send-btn:hover { background: var(--primary-dark); }
.send-btn:disabled { opacity: 0.5; cursor: not-allowed; }

@media (max-width: 768px) { .chat-sidebar { display: none; } }
</style>
