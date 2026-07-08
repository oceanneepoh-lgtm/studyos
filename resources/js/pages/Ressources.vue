<template>
  <div>
    <div class="page-header">
      <div>
        <h1 class="page-title" style="margin-bottom:0">Ressources</h1>
        <p class="page-sub">Cours, examens, TD et fiches de revision</p>
      </div>
    </div>

    <div class="filters-bar">
      <div class="filter-search">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input v-model="filters.search" @input="loadRessources" placeholder="Rechercher une ressource..." />
      </div>
      <select v-model="filters.type" @change="loadRessources" class="filter-select">
        <option value="">Tous types</option>
        <option value="cours">Cours</option>
        <option value="examen">Examen</option>
        <option value="td">TD</option>
        <option value="tp">TP</option>
        <option value="fiche_revision">Fiche de revision</option>
      </select>
      <select v-model="filters.filiere" @change="loadRessources" class="filter-select">
        <option value="">Toutes filieres</option>
        <option>Genie Logiciel</option>
        <option>Telecommunication</option>
        <option>Commerce International</option>
        <option>Marketing-Commerce-Vente</option>
        <option>Comptabilite et gestion</option>
      </select>
    </div>

    <div v-if="ressources.length === 0" class="card empty-state">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
      <p style="margin-top:0.8rem">Aucune ressource trouvee</p>
    </div>

    <div v-for="r in ressources" :key="r.id" class="resource-card">
      <div class="resource-icon" :class="'type-' + r.type">
        <svg v-if="r.type==='cours'" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        <svg v-else-if="r.type==='examen'" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <svg v-else width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
      </div>
      <div class="resource-info">
        <h3>{{ r.titre }}</h3>
        <p v-if="r.description" class="resource-desc">{{ r.description }}</p>
        <div class="resource-tags">
          <span class="badge badge-primary">{{ r.type }}</span>
          <span v-if="r.filiere" class="badge badge-success">{{ r.filiere }}</span>
          <span v-if="r.niveau" class="badge badge-primary">{{ r.niveau }}</span>
        </div>
      </div>
      <div class="resource-action">
        <button v-if="r.fichier" @click="download(r)" class="btn btn-primary btn-sm">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
          Telecharger
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import api from '../api';

const ressources = ref([]);
const filters = reactive({ search: '', type: '', filiere: '' });

async function loadRessources() {
  const params = {};
  if (filters.search) params.search = filters.search;
  if (filters.type) params.type = filters.type;
  if (filters.filiere) params.filiere = filters.filiere;
  const { data } = await api.get('/ressources', { params });
  ressources.value = data.data || data;
}

function download(r) {
  window.open(`/api/ressources/${r.id}/download`, '_blank');
}

onMounted(loadRessources);
</script>

<style scoped>
.page-header { margin-bottom: 1.5rem; }
.page-sub { font-size: 0.88rem; color: var(--text-light); margin-top: 0.3rem; }

.filters-bar { display: flex; gap: 0.8rem; margin-bottom: 1.5rem; }
.filter-search {
  flex: 1; display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid var(--border);
  border-radius: 10px; padding: 0 1rem; height: 42px;
}
.filter-search input { border: none; outline: none; font-size: 0.88rem; width: 100%; background: transparent; }
.filter-select { padding: 0 1rem; height: 42px; border: 1px solid var(--border); border-radius: 10px; font-size: 0.85rem; background: #fff; color: var(--text); outline: none; cursor: pointer; }

.resource-card {
  display: flex; align-items: center; gap: 1rem; background: #fff; border: 1px solid var(--border);
  border-radius: 12px; padding: 1.2rem 1.5rem; margin-bottom: 0.8rem; transition: all 0.2s;
}
.resource-card:hover { border-color: var(--primary); box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
.resource-icon {
  width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.type-cours { background: #eef2ff; color: #4f46e5; }
.type-examen { background: #fef2f2; color: #dc2626; }
.type-td { background: #ecfdf5; color: #059669; }
.type-tp { background: #fef3c7; color: #d97706; }
.type-fiche_revision { background: #fce7f3; color: #db2777; }
.resource-info { flex: 1; min-width: 0; }
.resource-info h3 { font-size: 0.95rem; font-weight: 600; margin-bottom: 0.3rem; }
.resource-desc { font-size: 0.82rem; color: var(--text-light); margin-bottom: 0.5rem; }
.resource-tags { display: flex; gap: 0.4rem; flex-wrap: wrap; }
.resource-action { flex-shrink: 0; }

.empty-state { text-align: center; padding: 3rem; color: #94a3b8; }
</style>
