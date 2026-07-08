<template>
  <div>
    <div class="welcome-bar">
      <div>
        <h1 class="welcome-title">Bonjour, {{ auth.user?.prenom }} !</h1>
        <p class="welcome-sub">Bienvenue sur votre espace academique INSAM</p>
      </div>
      <div class="welcome-info">
        <span class="welcome-badge">{{ auth.user?.etudiant?.filiere }}</span>
        <span class="welcome-badge outline">{{ auth.user?.etudiant?.niveau }}</span>
      </div>
    </div>

    <div class="grid-4 mb-2">
      <router-link to="/chat" class="quick-card">
        <div class="quick-icon" style="background:#eef2ff;color:#4f46e5">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div class="quick-label">Assistant IA</div>
        <div class="quick-desc">Posez vos questions</div>
      </router-link>
      <router-link to="/ressources" class="quick-card">
        <div class="quick-icon" style="background:#ecfdf5;color:#059669">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <div class="quick-label">Ressources</div>
        <div class="quick-desc">Cours et examens</div>
      </router-link>
      <router-link to="/quizzes" class="quick-card">
        <div class="quick-icon" style="background:#fef3c7;color:#d97706">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        </div>
        <div class="quick-label">Evaluations</div>
        <div class="quick-desc">Testez vos connaissances</div>
      </router-link>
      <router-link to="/recommandations" class="quick-card">
        <div class="quick-icon" style="background:#fce7f3;color:#db2777">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="quick-label">Recommandations</div>
        <div class="quick-desc">Conseils personnalises</div>
      </router-link>
    </div>

    <div class="grid-2">
      <div class="card">
        <div class="card-header-row">
          <h2>Mon Profil</h2>
          <router-link to="/profil" class="btn btn-outline btn-sm">Voir</router-link>
        </div>
        <div class="profile-info">
          <div class="profile-row">
            <span class="profile-label">Matricule</span>
            <span class="profile-value mono">{{ auth.user?.etudiant?.matricule }}</span>
          </div>
          <div class="profile-row">
            <span class="profile-label">Filiere</span>
            <span class="profile-value">{{ auth.user?.etudiant?.filiere }}</span>
          </div>
          <div class="profile-row">
            <span class="profile-label">Niveau</span>
            <span class="profile-value">{{ auth.user?.etudiant?.niveau }}</span>
          </div>
          <div class="profile-row">
            <span class="profile-label">Email</span>
            <span class="profile-value">{{ auth.user?.email }}</span>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header-row">
          <h2>Derniers resultats</h2>
          <router-link to="/quizzes" class="btn btn-outline btn-sm">Tous</router-link>
        </div>
        <div v-if="resultats.length === 0" class="empty-light">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          <p>Aucun quiz passe pour le moment</p>
        </div>
        <div v-for="r in resultats.slice(0,5)" :key="r.id" class="result-row">
          <div class="result-info">
            <div class="result-title">{{ r.quiz?.titre }}</div>
            <div class="result-date">{{ r.quiz?.matiere }}</div>
          </div>
          <div class="result-score" :class="r.score/r.total >= 0.5 ? 'good' : 'low'">
            {{ r.score }}/{{ r.total }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { auth } from '../stores/auth';
import api from '../api';

const resultats = ref([]);
onMounted(async () => {
  try {
    const { data } = await api.get('/mes-resultats');
    resultats.value = data;
  } catch {}
});
</script>

<style scoped>
.welcome-bar {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 1.5rem; padding: 1.5rem 2rem; background: linear-gradient(135deg, #4f46e5, #7c3aed);
  border-radius: 16px; color: #fff;
}
.welcome-title { font-size: 1.4rem; font-weight: 700; }
.welcome-sub { font-size: 0.88rem; opacity: 0.85; margin-top: 4px; }
.welcome-info { display: flex; gap: 8px; }
.welcome-badge { background: rgba(255,255,255,0.2); padding: 0.35rem 0.9rem; border-radius: 8px; font-size: 0.8rem; font-weight: 500; }
.welcome-badge.outline { background: transparent; border: 1px solid rgba(255,255,255,0.3); }

.quick-card {
  background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem;
  text-align: center; transition: all 0.2s; cursor: pointer; text-decoration: none; color: inherit;
}
.quick-card:hover { border-color: var(--primary); transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
.quick-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.8rem; }
.quick-label { font-size: 0.92rem; font-weight: 600; color: var(--text); }
.quick-desc { font-size: 0.78rem; color: var(--text-light); margin-top: 4px; }

.card-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.card-header-row h2 { margin-bottom: 0; }

.profile-info { }
.profile-row { display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid #f1f5f9; }
.profile-row:last-child { border-bottom: none; }
.profile-label { font-size: 0.85rem; color: var(--text-light); }
.profile-value { font-size: 0.88rem; font-weight: 500; color: var(--text); }
.profile-value.mono { font-family: monospace; color: var(--primary); }

.empty-light { text-align: center; padding: 2rem; color: #94a3b8; }
.empty-light p { margin-top: 0.5rem; font-size: 0.85rem; }

.result-row { display: flex; justify-content: space-between; align-items: center; padding: 0.65rem 0; border-bottom: 1px solid #f1f5f9; }
.result-row:last-child { border-bottom: none; }
.result-title { font-size: 0.88rem; font-weight: 500; }
.result-date { font-size: 0.78rem; color: var(--text-light); }
.result-score {
  padding: 0.3rem 0.8rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700;
}
.result-score.good { background: #ecfdf5; color: #059669; }
.result-score.low { background: #fef2f2; color: #dc2626; }
</style>
