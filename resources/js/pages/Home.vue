<template>
  <div>
    <div class="hero">
      <div class="hero-badge">IUES/INSAM - Bafoussam</div>
      <h1>Plateforme Intelligente<br/><span>d'Accompagnement Academique</span></h1>
      <p>Votre assistant virtuel IA pour reussir vos etudes. Acces aux ressources, sujets d'examens, quiz interactifs et conseils personnalises.</p>
      <div class="hero-actions">
        <router-link to="/register" class="btn btn-primary btn-lg">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
          S'inscrire gratuitement
        </router-link>
        <router-link to="/login" class="btn btn-outline btn-lg">Se connecter</router-link>
      </div>
    </div>

    <div class="features-section">
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon" style="background:#eef2ff;color:#4f46e5">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </div>
          <h3>Assistant IA</h3>
          <p>Posez vos questions academiques et obtenez des reponses instantanees basees sur vos cours</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon" style="background:#ecfdf5;color:#059669">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
          </div>
          <h3>Ressources</h3>
          <p>Acces aux cours, sujets d'examens, TD, TP et fiches de revision par filiere</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon" style="background:#fef3c7;color:#d97706">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <h3>Evaluations</h3>
          <p>Testez vos connaissances avec des quiz interactifs et suivez votre progression</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon" style="background:#fce7f3;color:#db2777">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
          </div>
          <h3>Bot WhatsApp</h3>
          <p>Posez vos questions directement via WhatsApp et recevez des reponses IA instantanees</p>
        </div>
      </div>
    </div>

    <div class="cta-section">
      <div class="cta-card">
        <h2>Pret a ameliorer vos resultats ?</h2>
        <p>Rejoignez la plateforme et accellerez votre reussite academique avec l'intelligence artificielle.</p>
        <router-link to="/register" class="btn btn-primary btn-lg">Commencer maintenant</router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.hero-badge {
  display: inline-block; background: var(--primary-light); color: var(--primary);
  padding: 0.4rem 1.2rem; border-radius: 20px; font-size: 0.82rem; font-weight: 600;
  margin-bottom: 1.5rem; letter-spacing: 0.5px;
}
.btn-lg { padding: 0.85rem 1.8rem; font-size: 0.95rem; border-radius: 10px; }

.features-section { max-width: 1000px; margin: 0 auto; padding: 0 2rem 3rem; }
.features-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem; }
.feature-card {
  background: #fff; border: 1px solid var(--border); border-radius: 14px;
  padding: 1.8rem 1.5rem; text-align: center; transition: all 0.3s;
}
.feature-card:hover { border-color: var(--primary); transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
.feature-icon {
  width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center;
  justify-content: center; margin: 0 auto 1rem;
}
.feature-card h3 { font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text); }
.feature-card p { font-size: 0.82rem; color: var(--text-light); line-height: 1.5; }

.cta-section { max-width: 700px; margin: 0 auto; padding: 0 2rem 4rem; }
.cta-card {
  background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 20px;
  padding: 3rem; text-align: center; color: #fff;
}
.cta-card h2 { font-size: 1.6rem; margin-bottom: 0.8rem; font-weight: 700; }
.cta-card p { opacity: 0.9; margin-bottom: 1.5rem; font-size: 1rem; }
.cta-card .btn { background: #fff; color: var(--primary); }
.cta-card .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.2); }

@media (max-width: 768px) {
  .features-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 500px) {
  .features-grid { grid-template-columns: 1fr; }
}
</style>
