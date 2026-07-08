<template>
  <div v-if="quiz" style="max-width:700px;margin:0 auto">
    <h1 class="page-title">{{ quiz.titre }}</h1>
    <p class="text-light mb-2">{{ quiz.matiere }} {{ quiz.chapitre ? '- ' + quiz.chapitre : '' }}</p>

    <div v-if="!result">
      <div v-for="(q, idx) in quiz.questions" :key="q.id" class="card">
        <h3>Question {{ idx + 1 }}: {{ q.question }}</h3>
        <div class="mt-1">
          <label v-for="opt in q.options" :key="opt"
            class="quiz-option" :class="{ selected: answers[q.id] === opt }"
            @click="answers[q.id] = opt">
            <input type="radio" :name="'q'+q.id" :value="opt" v-model="answers[q.id]" style="display:none" />
            {{ opt }}
          </label>
        </div>
      </div>
      <button @click="submit" class="btn btn-primary" style="width:100%;padding:0.8rem" :disabled="submitting">
        {{ submitting ? 'Envoi...' : 'Valider mes reponses' }}
      </button>
    </div>

    <div v-else class="card text-center">
      <div style="font-size:3rem;margin-bottom:1rem">{{ result.pourcentage >= 50 ? '🎉' : '📖' }}</div>
      <h2>Score: {{ result.score }}/{{ result.total }} ({{ result.pourcentage }}%)</h2>
      <p class="text-light mt-1">{{ result.pourcentage >= 50 ? 'Bien joue ! Continuez comme ca.' : 'Revisez et reessayez !' }}</p>
      <div class="flex gap-1 mt-2" style="justify-content:center">
        <router-link to="/quizzes" class="btn btn-outline">Retour aux quiz</router-link>
        <button @click="retry" class="btn btn-primary">Recommencer</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import api from '../api';

const route = useRoute();
const quiz = ref(null);
const answers = reactive({});
const result = ref(null);
const submitting = ref(false);

onMounted(async () => {
  const { data } = await api.get(`/quizzes/${route.params.id}`);
  quiz.value = data;
});

async function submit() {
  submitting.value = true;
  try {
    const { data } = await api.post(`/quizzes/${quiz.value.id}/submit`, { reponses: answers });
    result.value = data;
  } catch {}
  submitting.value = false;
}

function retry() {
  result.value = null;
  Object.keys(answers).forEach(k => delete answers[k]);
}
</script>
