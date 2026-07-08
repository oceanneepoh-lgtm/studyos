<template>
  <div class="auth-page">
    <div class="auth-card wide">
      <div class="auth-header">
        <div class="auth-logo">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        </div>
        <h2>Inscription Etudiant</h2>
        <p class="auth-sub">Creez votre compte IUES/INSAM</p>
      </div>
      <div v-if="error" class="alert alert-error">{{ error }}</div>
      <form @submit.prevent="handleRegister">
        <div class="grid-2">
          <div class="form-group">
            <label>Nom</label>
            <input v-model="form.nom" required placeholder="Votre nom" />
          </div>
          <div class="form-group">
            <label>Prenom</label>
            <input v-model="form.prenom" required placeholder="Votre prenom" />
          </div>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input v-model="form.email" type="email" required placeholder="votre@email.com" />
        </div>
        <div class="form-group">
          <label>Mot de passe</label>
          <input v-model="form.password" type="password" required minlength="6" placeholder="Minimum 6 caracteres" />
        </div>
        <div class="form-group">
          <label>Matricule</label>
          <input v-model="form.matricule" required placeholder="ex: 22INS001" />
        </div>
        <div class="grid-2">
          <div class="form-group">
            <label>Filiere</label>
            <select v-model="form.filiere" required>
              <option value="">-- Choisir --</option>
              <option>Genie Logiciel</option>
              <option>Gestion des systemes d'information</option>
              <option>Telecommunication</option>
              <option>Infographie et web design</option>
              <option>Commerce International</option>
              <option>Marketing-Commerce-Vente</option>
              <option>Comptabilite et gestion</option>
              <option>Banque et finance</option>
              <option>Gestion des ressources humaines</option>
              <option>Sciences infirmieres</option>
              <option>Sage-femme</option>
              <option>Kinesitherapie</option>
            </select>
          </div>
          <div class="form-group">
            <label>Niveau</label>
            <select v-model="form.niveau" required>
              <option value="">-- Choisir --</option>
              <option>BTS 1</option>
              <option>BTS 2</option>
              <option>Licence</option>
              <option>Master 1</option>
              <option>Master 2</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-full" :disabled="loading">
          {{ loading ? 'Inscription...' : "S'inscrire" }}
        </button>
      </form>
      <p class="auth-footer">
        Deja inscrit ? <router-link to="/login">Se connecter</router-link>
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
const form = reactive({ nom: '', prenom: '', email: '', password: '', matricule: '', filiere: '', niveau: '' });

async function handleRegister() {
  loading.value = true;
  error.value = '';
  try {
    const { data } = await api.post('/register', form);
    auth.setUser(data.user, data.token);
    router.push('/dashboard');
  } catch (e) {
    error.value = e.response?.data?.message || Object.values(e.response?.data?.errors || {}).flat().join(', ') || 'Erreur';
  }
  loading.value = false;
}
</script>

<style scoped>
.auth-page { min-height: calc(100vh - 140px); display: flex; align-items: center; justify-content: center; padding: 2rem; }
.auth-card { background: #fff; border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 420px; border: 1px solid var(--border); box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
.auth-card.wide { max-width: 520px; }
.auth-header { text-align: center; margin-bottom: 1.5rem; }
.auth-logo { width: 56px; height: 56px; border-radius: 14px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
.auth-header h2 { font-size: 1.4rem; font-weight: 700; color: var(--text); }
.auth-sub { font-size: 0.88rem; color: var(--text-light); margin-top: 0.3rem; }
.btn-full { width: 100%; justify-content: center; padding: 0.75rem; font-size: 0.95rem; }
.auth-footer { text-align: center; font-size: 0.85rem; color: var(--text-light); margin-top: 1.5rem; }
.auth-footer a { color: var(--primary); font-weight: 600; }
</style>
