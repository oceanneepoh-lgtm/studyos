<template>
  <div style="max-width:500px;margin:0 auto">
    <h1 class="page-title">Mon Profil</h1>
    <div class="card">
      <div class="text-center mb-2">
        <div style="width:80px;height:80px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto">
          {{ auth.user?.prenom?.[0] }}{{ auth.user?.nom?.[0] }}
        </div>
      </div>
      <div class="form-group"><label>Nom</label><input :value="auth.user?.nom" disabled /></div>
      <div class="form-group"><label>Prenom</label><input :value="auth.user?.prenom" disabled /></div>
      <div class="form-group"><label>Email</label><input :value="auth.user?.email" disabled /></div>
      <div v-if="auth.user?.etudiant">
        <div class="form-group"><label>Matricule</label><input :value="auth.user.etudiant.matricule" disabled /></div>
        <div class="form-group"><label>Filiere</label><input :value="auth.user.etudiant.filiere" disabled /></div>
        <div class="form-group"><label>Niveau</label><input :value="auth.user.etudiant.niveau" disabled /></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { auth } from '../stores/auth';
</script>
