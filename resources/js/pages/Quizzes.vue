<template>
  <div>
    <div class="page-header">
      <div>
        <h1 class="page-title" style="margin-bottom:0">Evaluations</h1>
        <p class="page-sub">Testez vos connaissances avec des quiz interactifs</p>
      </div>
    </div>

    <div v-if="quizzes.length === 0" class="card empty-state">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      <p style="margin-top:0.8rem">Aucun quiz disponible pour le moment</p>
    </div>

    <div class="quiz-grid">
      <div v-for="q in quizzes" :key="q.id" class="quiz-card">
        <div class="quiz-card-top">
          <div class="quiz-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <span class="quiz-questions-count">{{ q.questions_count }} questions</span>
        </div>
        <h3 class="quiz-title">{{ q.titre }}</h3>
        <p class="quiz-matiere">{{ q.matiere }} {{ q.chapitre ? '- ' + q.chapitre : '' }}</p>
        <div class="quiz-tags">
          <span v-if="q.filiere" class="badge badge-success">{{ q.filiere }}</span>
          <span v-if="q.niveau" class="badge badge-primary">{{ q.niveau }}</span>
        </div>
        <router-link :to="`/quizzes/${q.id}`" class="btn btn-primary btn-full quiz-start-btn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
          Commencer
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api';

const quizzes = ref([]);
onMounted(async () => {
  const { data } = await api.get('/quizzes');
  quizzes.value = data;
});
</script>

<style scoped>
.page-header { margin-bottom: 1.5rem; }
.page-sub { font-size: 0.88rem; color: var(--text-light); margin-top: 0.3rem; }
.empty-state { text-align: center; padding: 3rem; color: #94a3b8; }

.quiz-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
.quiz-card {
  background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem;
  transition: all 0.2s; display: flex; flex-direction: column;
}
.quiz-card:hover { border-color: var(--primary); transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
.quiz-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.quiz-icon { width: 42px; height: 42px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; }
.quiz-questions-count { font-size: 0.78rem; color: var(--text-light); font-weight: 500; background: #f8fafc; padding: 0.25rem 0.7rem; border-radius: 6px; }
.quiz-title { font-size: 1rem; font-weight: 600; margin-bottom: 0.3rem; }
.quiz-matiere { font-size: 0.82rem; color: var(--text-light); margin-bottom: 0.8rem; }
.quiz-tags { display: flex; gap: 0.4rem; margin-bottom: 1.2rem; flex-wrap: wrap; }
.quiz-start-btn { margin-top: auto; justify-content: center; }
.btn-full { width: 100%; }

@media (max-width: 768px) { .quiz-grid { grid-template-columns: 1fr; } }
</style>
