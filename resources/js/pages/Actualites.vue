<template>
  <div>
    <h1 class="page-title">Actualites</h1>
    <div v-if="actualites.length === 0" class="card text-center text-light">Aucune actualite</div>
    <div v-for="a in actualites" :key="a.id" class="card">
      <h3>{{ a.titre }}</h3>
      <p class="text-sm text-light mb-1">{{ a.date_publication || new Date(a.created_at).toLocaleDateString('fr-FR') }}</p>
      <p>{{ a.description }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api';

const actualites = ref([]);
onMounted(async () => {
  const { data } = await api.get('/actualites');
  actualites.value = data.data || data;
});
</script>
