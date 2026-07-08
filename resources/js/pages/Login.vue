<template>
  <div class="auth-page">
    <div class="auth-card">
      <div class="auth-header">
        <div class="auth-logo">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        </div>
        <h2>Connexion</h2>
        <p class="auth-sub">Accedez a votre espace IUES/INSAM</p>
      </div>
      <div v-if="error" class="alert alert-error">{{ error }}</div>
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label>Adresse email</label>
          <input v-model="form.email" type="email" required placeholder="votre@email.com" />
        </div>
        <div class="form-group">
          <label>Mot de passe</label>
          <input v-model="form.password" type="password" required placeholder="Votre mot de passe" />
        </div>
        <button type="submit" class="btn btn-primary btn-full" :disabled="loading">
          {{ loading ? 'Connexion...' : 'Se connecter' }}
        </button>
      </form>
      <p class="auth-footer">
        Pas encore de compte ? <router-link to="/register">S'inscrire</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';
import { auth } from '../stores/auth';

const router = useRouter();
const loading = ref(false);
const error = ref('');
const form = reactive({ email: '', password: '' });

async function handleLogin() {
  loading.value = true;
  error.value = '';
  try {
    const { data } = await api.post('/login', form);
    auth.setUser(data.user, data.token);
    router.push(data.user.role === 'admin' ? '/admin' : '/dashboard');
  } catch (e) {
    error.value = e.response?.data?.message || 'Identifiants incorrects';
  }
  loading.value = false;
}
</script>

<style scoped>
.auth-page { min-height: calc(100vh - 140px); display: flex; align-items: center; justify-content: center; padding: 2rem; }
.auth-card { background: #fff; border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 420px; border: 1px solid var(--border); box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
.auth-header { text-align: center; margin-bottom: 1.5rem; }
.auth-logo { width: 56px; height: 56px; border-radius: 14px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
.auth-header h2 { font-size: 1.4rem; font-weight: 700; color: var(--text); }
.auth-sub { font-size: 0.88rem; color: var(--text-light); margin-top: 0.3rem; }
.btn-full { width: 100%; justify-content: center; padding: 0.75rem; font-size: 0.95rem; }
.auth-footer { text-align: center; font-size: 0.85rem; color: var(--text-light); margin-top: 1.5rem; }
.auth-footer a { color: var(--primary); font-weight: 600; }
</style>
