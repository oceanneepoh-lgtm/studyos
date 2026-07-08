<template>
  <div>
    <div class="page-header-row">
      <div>
        <h1 class="page-title" style="margin-bottom:0">Recommandations</h1>
        <p class="page-sub">Conseils personnalises generes par l'IA</p>
      </div>
      <button @click="generate" class="btn btn-primary" :disabled="loading">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        {{ loading ? 'Generation...' : 'Generer des recommandations' }}
      </button>
    </div>

    <div v-if="recos.length === 0" class="card empty-state">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      <p style="margin-top:0.8rem">Cliquez sur "Generer" pour obtenir des recommandations personnalisees</p>
    </div>

    <div v-for="r in recos" :key="r.id" class="reco-card">
      <div class="reco-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div class="reco-body">
        <p class="reco-text">{{ r.message }}</p>
        <span class="reco-date">{{ new Date(r.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api';

const recos = ref([]);
const loading = ref(false);

onMounted(async () => {
  const { data } = await api.get('/recommandations');
  recos.value = data;
});

async function generate() {
  loading.value = true;
  try {
    const { data } = await api.post('/recommandations/generate');
    recos.value.unshift(data);
  } catch {}
  loading.value = false;
}
</script>

<style scoped>
.page-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; }
.page-sub { font-size: 0.88rem; color: var(--text-light); margin-top: 0.3rem; }
.empty-state { text-align: center; padding: 3rem; color: #94a3b8; }

.reco-card {
  display: flex; gap: 1rem; background: #fff; border: 1px solid var(--border); border-radius: 12px;
  padding: 1.2rem 1.5rem; margin-bottom: 0.8rem; transition: all 0.2s;
}
.reco-card:hover { border-color: var(--primary); }
.reco-icon { width: 40px; height: 40px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.reco-body { flex: 1; }
.reco-text { font-size: 0.9rem; line-height: 1.6; white-space: pre-wrap; color: var(--text); }
.reco-date { font-size: 0.78rem; color: #94a3b8; margin-top: 0.5rem; display: block; }
</style>
