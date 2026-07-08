<template>
  <div class="app">
    <template v-if="isAdminRoute">
      <router-view />
    </template>
    <template v-else>
      <nav class="navbar" v-if="auth.isLoggedIn">
        <div class="nav-brand">
          <router-link to="/dashboard">INSAM Platform</router-link>
        </div>
        <div class="nav-links">
          <router-link to="/dashboard">Tableau de bord</router-link>
          <router-link to="/chat">Assistant IA</router-link>
          <router-link to="/ressources">Ressources</router-link>
          <router-link to="/quizzes">Evaluations</router-link>
          <router-link to="/recommandations">Recommandations</router-link>
          <router-link to="/actualites">Actualites</router-link>
          <router-link to="/admin" v-if="auth.isAdmin">Administration</router-link>
        </div>
        <div class="nav-user">
          <router-link to="/profil" class="user-name">{{ auth.user?.prenom }} {{ auth.user?.nom }}</router-link>
          <button @click="handleLogout" class="btn-logout">Deconnexion</button>
        </div>
      </nav>
      <nav class="navbar" v-else>
        <div class="nav-brand">
          <router-link to="/">INSAM Platform</router-link>
        </div>
        <div class="nav-links">
          <router-link to="/actualites">Actualites</router-link>
          <router-link to="/login">Connexion</router-link>
          <router-link to="/register" class="btn-register">Inscription</router-link>
        </div>
      </nav>
      <main class="main-content">
        <router-view />
      </main>
    </template>
  </div>
</template>

<script setup>
import { auth } from './stores/auth';
import { useRouter, useRoute } from 'vue-router';
import { computed } from 'vue';

const router = useRouter();
const route = useRoute();
const isAdminRoute = computed(() => route.path === '/admin');

async function handleLogout() {
  await auth.logout();
  router.push('/login');
}
</script>
