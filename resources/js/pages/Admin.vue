<template>
  <div class="admin-shell">
    <!-- SIDEBAR -->
    <aside class="sidebar" :class="{ collapsed: sidebarCollapsed }">
      <div class="sidebar-header">
        <div class="sidebar-logo">
          <div class="logo-circle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
          </div>
          <div v-if="!sidebarCollapsed">
            <div class="logo-text">IUES/INSAM</div>
            <div class="logo-sub">Administration</div>
          </div>
        </div>
      </div>

      <nav class="sidebar-menu">
        <div class="menu-label" v-if="!sidebarCollapsed">PRINCIPAL</div>
        <a v-for="item in menuItems" :key="item.id"
           class="menu-item" :class="{ active: tab === item.id }"
           @click="tab = item.id">
          <span class="menu-icon" v-html="item.icon"></span>
          <span class="menu-text" v-if="!sidebarCollapsed">{{ item.label }}</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <a class="menu-item" @click="goToDashboard">
          <span class="menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg></span>
          <span class="menu-text" v-if="!sidebarCollapsed">Retour au site</span>
        </a>
        <a class="menu-item logout" @click="handleLogout">
          <span class="menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg></span>
          <span class="menu-text" v-if="!sidebarCollapsed">Deconnexion</span>
        </a>
      </div>
    </aside>

    <!-- MAIN AREA -->
    <div class="admin-body">
      <!-- TOP BAR -->
      <header class="topbar">
        <div class="topbar-left">
          <button class="toggle-btn" @click="sidebarCollapsed = !sidebarCollapsed">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
          </button>
          <h1 class="page-title">{{ currentTitle }}</h1>
        </div>
        <div class="topbar-right">
          <div class="topbar-date">{{ todayDate }}</div>
          <div class="topbar-user">
            <div class="user-avatar">{{ auth.user?.prenom?.[0] }}{{ auth.user?.nom?.[0] }}</div>
            <div class="user-info">
              <div class="user-name">{{ auth.user?.prenom }} {{ auth.user?.nom }}</div>
              <div class="user-role">Administrateur</div>
            </div>
          </div>
        </div>
      </header>

      <!-- CONTENT -->
      <div class="admin-content">

        <!-- ===== DASHBOARD ===== -->
        <div v-if="tab === 'dashboard'">
          <!-- Big stat cards -->
          <div class="stat-row">
            <div class="stat-card grad-purple">
              <div class="stat-card-body">
                <div class="stat-number">{{ stats.etudiants }}</div>
                <div class="stat-label">Etudiants inscrits</div>
              </div>
              <div class="stat-card-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
              <div class="stat-card-trend">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                inscrits
              </div>
            </div>
            <div class="stat-card grad-pink">
              <div class="stat-card-body">
                <div class="stat-number">{{ stats.ressources }}</div>
                <div class="stat-label">Ressources</div>
              </div>
              <div class="stat-card-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.4"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></div>
              <div class="stat-card-trend">documents</div>
            </div>
            <div class="stat-card grad-blue">
              <div class="stat-card-body">
                <div class="stat-number">{{ stats.quizzes }}</div>
                <div class="stat-label">Evaluations</div>
              </div>
              <div class="stat-card-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.4"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
              <div class="stat-card-trend">quiz actifs</div>
            </div>
            <div class="stat-card grad-green">
              <div class="stat-card-body">
                <div class="stat-number">{{ stats.questions }}</div>
                <div class="stat-label">Questions IA</div>
              </div>
              <div class="stat-card-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.4"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
              <div class="stat-card-trend">conversations</div>
            </div>
          </div>

          <!-- Secondary stats -->
          <div class="stat-row-sm">
            <div class="mini-stat">
              <div class="mini-icon" style="background:#ede9fe;color:#7c3aed"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2z"/></svg></div>
              <div><div class="mini-label">Actualites</div><div class="mini-value">{{ stats.actualites }}</div></div>
            </div>
            <div class="mini-stat">
              <div class="mini-icon" style="background:#fce7f3;color:#db2777"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg></div>
              <div><div class="mini-label">Telechargements</div><div class="mini-value">{{ stats.downloads || 0 }}</div></div>
            </div>
            <div class="mini-stat">
              <div class="mini-icon" style="background:#dbeafe;color:#2563eb"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
              <div><div class="mini-label">Quiz passes</div><div class="mini-value">{{ stats.quiz_attempts || 0 }}</div></div>
            </div>
            <div class="mini-stat">
              <div class="mini-icon" style="background:#d1fae5;color:#059669"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
              <div><div class="mini-label">Score moyen</div><div class="mini-value">{{ stats.avg_score || 0 }}%</div></div>
            </div>
          </div>

          <!-- Charts row -->
          <div class="grid-2-1">
            <div class="card">
              <div class="card-head">
                <h3>Inscriptions des 6 derniers mois</h3>
              </div>
              <div class="chart-wrap">
                <canvas ref="chartEl"></canvas>
              </div>
            </div>
            <div class="card">
              <div class="card-head">
                <h3>Derniers inscrits</h3>
              </div>
              <div class="recent-list">
                <div v-for="e in etudiants.slice(0, 5)" :key="e.id" class="recent-row">
                  <div class="avatar-sm" :style="{background: avatarColors[e.id % avatarColors.length]}">{{ e.prenom?.[0] }}{{ e.nom?.[0] }}</div>
                  <div class="recent-info">
                    <div class="recent-name">{{ e.prenom }} {{ e.nom }}</div>
                    <div class="recent-sub">{{ e.etudiant?.filiere }} &middot; {{ e.etudiant?.niveau }}</div>
                  </div>
                </div>
                <div v-if="!etudiants.length" class="empty-state">Aucun etudiant inscrit</div>
              </div>
            </div>
          </div>

          <!-- Filiere distribution -->
          <div class="card">
            <div class="card-head"><h3>Repartition par filiere</h3></div>
            <div class="filiere-chart">
              <div v-for="(count, filiere) in filiereStats" :key="filiere" class="filiere-row">
                <span class="filiere-name">{{ filiere }}</span>
                <div class="filiere-track">
                  <div class="filiere-fill" :style="{width: (count / maxFiliere * 100) + '%'}"></div>
                </div>
                <span class="filiere-num">{{ count }}</span>
              </div>
              <div v-if="!Object.keys(filiereStats).length" class="empty-state">Aucune donnee</div>
            </div>
          </div>
        </div>

        <!-- ===== ETUDIANTS ===== -->
        <div v-if="tab === 'etudiants'">
          <div class="card">
            <div class="card-head">
              <h3>Liste des etudiants ({{ etudiants.length }})</h3>
              <div class="search-box">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input v-model="searchQuery" placeholder="Rechercher un etudiant..." />
              </div>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Matricule</th>
                    <th>Filiere</th>
                    <th>Niveau</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="e in filteredEtudiants" :key="e.id">
                    <td>
                      <div class="cell-user">
                        <div class="avatar-sm" :style="{background: avatarColors[e.id % avatarColors.length]}">{{ e.prenom?.[0] }}</div>
                        <span>{{ e.prenom }} {{ e.nom }}</span>
                      </div>
                    </td>
                    <td>{{ e.email }}</td>
                    <td><span class="tag tag-purple">{{ e.etudiant?.matricule }}</span></td>
                    <td>{{ e.etudiant?.filiere }}</td>
                    <td><span class="tag tag-blue">{{ e.etudiant?.niveau }}</span></td>
                    <td>
                      <button @click="deleteUser(e.id)" class="btn-sm btn-danger">Supprimer</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-if="!filteredEtudiants.length" class="empty-state">Aucun etudiant trouve</div>
            </div>
          </div>
        </div>

        <!-- ===== RESSOURCES ===== -->
        <div v-if="tab === 'ressources'">
          <div class="section-header">
            <h3>Gestion des ressources</h3>
            <button @click="showRessourceForm = !showRessourceForm" class="btn-primary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
              {{ showRessourceForm ? 'Annuler' : 'Ajouter une ressource' }}
            </button>
          </div>

          <div v-if="showRessourceForm" class="card mb-3">
            <div class="card-head"><h3>Nouvelle ressource</h3></div>
            <form @submit.prevent="addRessource" class="form-body">
              <div class="form-row">
                <div class="form-group"><label>Titre</label><input v-model="rForm.titre" required /></div>
                <div class="form-group"><label>Type</label>
                  <select v-model="rForm.type" required>
                    <option value="cours">Cours</option><option value="examen">Examen</option>
                    <option value="td">TD</option><option value="tp">TP</option>
                    <option value="fiche_revision">Fiche de revision</option>
                  </select>
                </div>
              </div>
              <div class="form-group"><label>Description</label><textarea v-model="rForm.description" rows="2"></textarea></div>
              <div class="form-row">
                <div class="form-group"><label>Filiere</label><input v-model="rForm.filiere" /></div>
                <div class="form-group"><label>Niveau</label><input v-model="rForm.niveau" /></div>
              </div>
              <div class="form-group"><label>Fichier (PDF, Word...)</label><input type="file" @change="rForm.fichier = $event.target.files[0]" /></div>
              <button type="submit" class="btn-primary">Enregistrer</button>
            </form>
          </div>

          <div class="card">
            <div class="card-head"><h3>Ressources disponibles</h3></div>
            <div class="empty-state" v-if="!ressourcesList.length">Les ressources apparaitront ici apres ajout</div>
            <div class="table-wrap" v-else>
              <table class="data-table">
                <thead><tr><th>Titre</th><th>Type</th><th>Filiere</th><th>Niveau</th></tr></thead>
                <tbody>
                  <tr v-for="r in ressourcesList" :key="r.id">
                    <td>{{ r.titre }}</td>
                    <td><span class="tag tag-green">{{ r.type }}</span></td>
                    <td>{{ r.filiere }}</td>
                    <td>{{ r.niveau }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ===== EVALUATIONS ===== -->
        <div v-if="tab === 'quizzes'">
          <div class="section-header">
            <h3>Gestion des evaluations</h3>
            <button @click="showQuizForm = !showQuizForm" class="btn-primary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
              {{ showQuizForm ? 'Annuler' : 'Creer un quiz' }}
            </button>
          </div>

          <div v-if="showQuizForm" class="card mb-3">
            <div class="card-head"><h3>Nouveau quiz</h3></div>
            <form @submit.prevent="addQuiz" class="form-body">
              <div class="form-row">
                <div class="form-group"><label>Titre</label><input v-model="qForm.titre" required /></div>
                <div class="form-group"><label>Matiere</label><input v-model="qForm.matiere" required /></div>
              </div>
              <div class="form-row form-row-3">
                <div class="form-group"><label>Chapitre</label><input v-model="qForm.chapitre" /></div>
                <div class="form-group"><label>Filiere</label><input v-model="qForm.filiere" /></div>
                <div class="form-group"><label>Niveau</label><input v-model="qForm.niveau" /></div>
              </div>
              <div class="questions-section">
                <h4>Questions</h4>
                <div v-for="(q, i) in qForm.questions" :key="i" class="question-block">
                  <div class="question-num">Q{{ i + 1 }}</div>
                  <div class="question-fields">
                    <div class="form-group"><label>Intitule</label><input v-model="q.question" required /></div>
                    <div class="form-group"><label>Options (separees par |)</label><input v-model="q.optionsText" required placeholder="Option A | Option B | Option C | Option D" /></div>
                    <div class="form-group"><label>Bonne reponse</label><input v-model="q.bonne_reponse" required /></div>
                  </div>
                </div>
                <button type="button" @click="qForm.questions.push({question:'',optionsText:'',bonne_reponse:''})" class="btn-outline">+ Ajouter une question</button>
              </div>
              <button type="submit" class="btn-primary" style="margin-top:1rem">Creer le quiz</button>
            </form>
          </div>
        </div>

        <!-- ===== ACTUALITES ===== -->
        <div v-if="tab === 'actualites'">
          <div class="section-header">
            <h3>Gestion des actualites</h3>
            <button @click="showActuForm = !showActuForm" class="btn-primary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
              {{ showActuForm ? 'Annuler' : 'Publier une actualite' }}
            </button>
          </div>

          <div v-if="showActuForm" class="card mb-3">
            <div class="card-head"><h3>Nouvelle actualite</h3></div>
            <form @submit.prevent="addActualite" class="form-body">
              <div class="form-group"><label>Titre</label><input v-model="aForm.titre" required /></div>
              <div class="form-group"><label>Contenu</label><textarea v-model="aForm.description" rows="4" required></textarea></div>
              <button type="submit" class="btn-primary">Publier</button>
            </form>
          </div>
        </div>

        <!-- ===== BASE DE CONNAISSANCES ===== -->
        <div v-if="tab === 'knowledge'">
          <div class="knowledge-intro card mb-3">
            <div class="card-head">
              <h3>Comment fonctionne la base de connaissances ?</h3>
            </div>
            <div class="knowledge-explain">
              <div class="knowledge-step">
                <div class="step-num">1</div>
                <div>
                  <strong>Vous uploadez des documents</strong>
                  <p>Cours PDF, supports Word, presentations PowerPoint, fichiers texte...</p>
                </div>
              </div>
              <div class="knowledge-step">
                <div class="step-num">2</div>
                <div>
                  <strong>Le texte est extrait automatiquement</strong>
                  <p>Le systeme lit le contenu de chaque document et le stocke dans la base.</p>
                </div>
              </div>
              <div class="knowledge-step">
                <div class="step-num">3</div>
                <div>
                  <strong>L'IA utilise ces connaissances</strong>
                  <p>Quand un etudiant pose une question, l'IA cherche dans vos documents pour donner des reponses precises et contextuelles.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="section-header">
            <h3>Documents ({{ knowledgeDocs.length }})</h3>
            <button @click="showKnowledgeForm = !showKnowledgeForm" class="btn-primary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
              {{ showKnowledgeForm ? 'Annuler' : 'Ajouter un document' }}
            </button>
          </div>

          <div v-if="showKnowledgeForm" class="card mb-3">
            <div class="card-head"><h3>Nouveau document</h3></div>
            <form @submit.prevent="addKnowledge" class="form-body">
              <div class="form-row">
                <div class="form-group"><label>Titre / Nom du cours</label><input v-model="kForm.titre" required placeholder="Ex: Cours de Marketing Digital" /></div>
                <div class="form-group"><label>Matiere</label><input v-model="kForm.matiere" placeholder="Ex: Marketing" /></div>
              </div>
              <div class="form-row">
                <div class="form-group"><label>Filiere (optionnel)</label><input v-model="kForm.filiere" placeholder="Ex: Informatique de Gestion" /></div>
                <div class="form-group"><label>Niveau (optionnel)</label><input v-model="kForm.niveau" placeholder="Ex: Licence 3" /></div>
              </div>
              <div class="form-group">
                <label>Fichier (PDF, Word, PowerPoint, TXT)</label>
                <input type="file" @change="kForm.fichier = $event.target.files[0]" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt" required />
              </div>
              <div class="form-group">
                <label>Contenu additionnel (optionnel)</label>
                <textarea v-model="kForm.contenu_additionnel" rows="4" placeholder="Vous pouvez coller du texte supplementaire ici (notes de cours, resumes, etc.)"></textarea>
              </div>
              <button type="submit" class="btn-primary">Ajouter a la base de connaissances</button>
            </form>
          </div>

          <div class="card" v-if="knowledgeDocs.length">
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Titre</th>
                    <th>Matiere</th>
                    <th>Filiere</th>
                    <th>Fichier</th>
                    <th>Taille contenu</th>
                    <th>Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="doc in knowledgeDocs" :key="doc.id">
                    <td><strong>{{ doc.titre }}</strong></td>
                    <td><span class="tag tag-purple" v-if="doc.matiere">{{ doc.matiere }}</span></td>
                    <td>{{ doc.filiere || '-' }}</td>
                    <td><span class="tag tag-blue">{{ doc.fichier_nom }}</span></td>
                    <td>{{ Math.round(doc.contenu_texte.length / 1000) }}k car.</td>
                    <td>{{ new Date(doc.created_at).toLocaleDateString('fr-FR') }}</td>
                    <td><button @click="deleteKnowledge(doc.id)" class="btn-sm btn-danger">Supprimer</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card" v-else>
            <div class="empty-state">
              <div style="font-size:2.5rem;margin-bottom:1rem">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3M12 17h.01"/></svg>
              </div>
              Aucun document dans la base de connaissances.<br/>
              Ajoutez des cours, supports et documents pour enrichir les reponses de l'IA.
            </div>
          </div>
        </div>

        <!-- ===== BOT WHATSAPP ===== -->
        <div v-if="tab === 'whatsapp'">
          <div class="wa-grid">
            <!-- Status card -->
            <div class="card">
              <div class="card-head"><h3>Statut du Bot</h3></div>
              <div class="wa-status-body">
                <div class="wa-status-indicator" :class="'wa-' + whatsappStatus.status">
                  <div class="wa-dot"></div>
                  <span v-if="whatsappStatus.status === 'connected'">Connecte</span>
                  <span v-else-if="whatsappStatus.status === 'qr_ready'">En attente de scan</span>
                  <span v-else-if="whatsappStatus.status === 'offline'">Bot hors ligne</span>
                  <span v-else>Deconnecte</span>
                </div>

                <div v-if="whatsappStatus.status === 'connected'" class="wa-connected-info">
                  <div class="wa-phone-card">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#25D366" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <div>
                      <div class="wa-phone-name">{{ whatsappStatus.name || 'Bot INSAM' }}</div>
                      <div class="wa-phone-num">+{{ whatsappStatus.phone }}</div>
                    </div>
                  </div>
                  <button @click="logoutWhatsApp" class="btn-sm btn-danger" style="margin-top:1rem">Deconnecter</button>
                </div>

                <div v-else-if="whatsappStatus.status === 'offline'" class="wa-offline">
                  <p>Le serveur du bot WhatsApp n'est pas demarre.</p>
                  <div class="wa-cmd">
                    <code>cd whatsapp-bot && npm start</code>
                  </div>
                </div>

                <div v-else class="wa-actions">
                  <button @click="restartWhatsApp" class="btn-outline">Redemarrer le bot</button>
                </div>
              </div>
            </div>

            <!-- QR Code -->
            <div class="card">
              <div class="card-head"><h3>QR Code WhatsApp</h3></div>
              <div class="wa-qr-body">
                <div v-if="whatsappStatus.status === 'qr_ready' && whatsappStatus.qr" class="wa-qr-container">
                  <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=' + encodeURIComponent(whatsappStatus.qr)" alt="QR Code" class="wa-qr-img" />
                  <p class="wa-qr-hint">Scannez avec WhatsApp sur votre telephone</p>
                  <p class="wa-qr-steps">WhatsApp > Menu (3 points) > Appareils connectes > Connecter un appareil</p>
                </div>
                <div v-else-if="whatsappStatus.status === 'connected'" class="wa-qr-success">
                  <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#25D366" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/></svg>
                  <p>Bot connecte et operationnel !</p>
                </div>
                <div v-else class="empty-state">
                  <p>Le QR code apparaitra ici une fois le bot demarre</p>
                </div>
              </div>
            </div>
          </div>

          <!-- How it works -->
          <div class="card">
            <div class="card-head"><h3>Comment ca fonctionne ?</h3></div>
            <div class="knowledge-explain">
              <div class="knowledge-step">
                <div class="step-num" style="background:#25D366">1</div>
                <div>
                  <strong>Demarrez le bot</strong>
                  <p>Lancez le serveur avec <code>cd whatsapp-bot &amp;&amp; npm start</code></p>
                </div>
              </div>
              <div class="knowledge-step">
                <div class="step-num" style="background:#25D366">2</div>
                <div>
                  <strong>Scannez le QR code</strong>
                  <p>Ouvrez WhatsApp > Appareils connectes > Scannez le QR code affiche</p>
                </div>
              </div>
              <div class="knowledge-step">
                <div class="step-num" style="background:#25D366">3</div>
                <div>
                  <strong>Les etudiants ecrivent au bot</strong>
                  <p>L'IA repond automatiquement en utilisant la base de connaissances INSAM</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== CONFIGURATION IA ===== -->
        <div v-if="tab === 'settings'">
          <div class="settings-grid">
            <!-- Provider selection -->
            <div class="card">
              <div class="card-head"><h3>Fournisseur d'IA</h3></div>
              <div class="form-body">
                <div class="provider-cards">
                  <div class="provider-card" :class="{ active: settingsForm.ai_provider === 'claude' }" @click="settingsForm.ai_provider = 'claude'">
                    <div class="provider-logo claude-logo">
                      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 3a3 3 0 0 1 3 3c0 1.5-1 2.5-2 3s-1 1-1 2m0 3h.01"/></svg>
                    </div>
                    <div class="provider-info">
                      <div class="provider-name">Claude (Anthropic)</div>
                      <div class="provider-desc">Modeles Claude : Haiku, Sonnet, Opus</div>
                    </div>
                    <div class="provider-check" v-if="settingsForm.ai_provider === 'claude'">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                  </div>
                  <div class="provider-card" :class="{ active: settingsForm.ai_provider === 'gemini' }" @click="settingsForm.ai_provider = 'gemini'">
                    <div class="provider-logo gemini-logo">
                      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div class="provider-info">
                      <div class="provider-name">Gemini (Google)</div>
                      <div class="provider-desc">Modeles Gemini : Flash, Pro</div>
                    </div>
                    <div class="provider-check" v-if="settingsForm.ai_provider === 'gemini'">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- API Keys -->
            <div class="card">
              <div class="card-head"><h3>Cles API</h3></div>
              <div class="form-body">
                <div class="form-group">
                  <label>
                    <span class="label-with-badge">
                      Cle API Anthropic (Claude)
                      <span v-if="aiSettings.anthropic_api_key" class="badge-configured">Configuree</span>
                      <span v-else class="badge-missing">Non configuree</span>
                    </span>
                  </label>
                  <input v-model="settingsForm.anthropic_api_key" type="password" placeholder="sk-ant-api03-..." />
                  <span class="form-hint">Obtenez votre cle sur console.anthropic.com</span>
                </div>
                <div class="form-group">
                  <label>Modele Claude</label>
                  <select v-model="settingsForm.claude_model">
                    <option value="claude-haiku-4-5-20251001">Claude Haiku 4.5 (rapide, economique)</option>
                    <option value="claude-sonnet-4-20250514">Claude Sonnet 4 (equilibre)</option>
                    <option value="claude-opus-4-20250514">Claude Opus 4 (puissant)</option>
                  </select>
                </div>
                <hr class="form-divider" />
                <div class="form-group">
                  <label>
                    <span class="label-with-badge">
                      Cle API Google (Gemini)
                      <span v-if="aiSettings.gemini_api_key" class="badge-configured">Configuree</span>
                      <span v-else class="badge-missing">Non configuree</span>
                    </span>
                  </label>
                  <input v-model="settingsForm.gemini_api_key" type="password" placeholder="AIza..." />
                  <span class="form-hint">Obtenez votre cle sur aistudio.google.com</span>
                </div>
                <div class="form-group">
                  <label>Modele Gemini</label>
                  <select v-model="settingsForm.gemini_model">
                    <option value="gemini-2.0-flash">Gemini 2.0 Flash (rapide, economique)</option>
                    <option value="gemini-2.5-flash-preview-05-20">Gemini 2.5 Flash (equilibre)</option>
                    <option value="gemini-2.5-pro-preview-06-05">Gemini 2.5 Pro (puissant)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="settings-actions">
            <button @click="saveSettings" class="btn-primary" :disabled="settingsSaving">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              {{ settingsSaving ? 'Sauvegarde...' : 'Sauvegarder la configuration' }}
            </button>
            <button @click="testAi" class="btn-outline" :disabled="settingsTesting">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
              {{ settingsTesting ? 'Test en cours...' : 'Tester la connexion' }}
            </button>
          </div>

          <!-- Test result -->
          <div v-if="testResult" class="card" style="margin-top:1rem">
            <div class="card-head">
              <h3>Resultat du test</h3>
              <span class="tag" :class="testResult.success ? 'tag-green' : 'tag-danger'">
                {{ testResult.success ? 'Succes' : 'Echec' }}
              </span>
            </div>
            <div class="test-result-body">
              <div class="test-provider">Fournisseur: <strong>{{ testResult.provider === 'claude' ? 'Claude (Anthropic)' : 'Gemini (Google)' }}</strong></div>
              <div class="test-response">{{ testResult.response }}</div>
            </div>
          </div>

          <!-- Settings saved toast -->
          <div v-if="settingsSaved" class="toast-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/></svg>
            Configuration sauvegardee avec succes !
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted, nextTick, computed, watch } from 'vue';
import { auth } from '../stores/auth';
import { useRouter } from 'vue-router';
import api from '../api';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

const router = useRouter();
const tab = ref('dashboard');
const sidebarCollapsed = ref(false);
const searchQuery = ref('');
const chartEl = ref(null);
let chartInstance = null;

const menuItems = [
  { id: 'dashboard', label: 'Tableau de bord', icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>' },
  { id: 'etudiants', label: 'Etudiants', icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>' },
  { id: 'ressources', label: 'Ressources', icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>' },
  { id: 'quizzes', label: 'Evaluations', icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>' },
  { id: 'actualites', label: 'Actualites', icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2z"/></svg>' },
  { id: 'knowledge', label: 'Base de connaissances', icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3M12 17h.01"/></svg>' },
  { id: 'whatsapp', label: 'Bot WhatsApp', icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>' },
  { id: 'settings', label: 'Configuration IA', icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>' },
];

const currentTitle = computed(() => {
  const item = menuItems.find(m => m.id === tab.value);
  return item ? item.label : 'Administration';
});

const todayDate = computed(() => {
  return new Date().toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
});

const avatarColors = ['#6366f1', '#ec4899', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'];

const stats = ref({ etudiants: 0, ressources: 0, quizzes: 0, questions: 0, actualites: 0, downloads: 0, quiz_attempts: 0, avg_score: 0 });
const etudiants = ref([]);
const ressourcesList = ref([]);

const showRessourceForm = ref(false);
const showQuizForm = ref(false);
const showActuForm = ref(false);
const showKnowledgeForm = ref(false);
const knowledgeDocs = ref([]);
const kForm = reactive({ titre: '', matiere: '', filiere: '', niveau: '', fichier: null, contenu_additionnel: '' });

const whatsappStatus = ref({ status: 'disconnected', qr: null, phone: null, name: null });
const waPolling = ref(null);

const aiSettings = ref({ provider: 'claude', anthropic_api_key: null, gemini_api_key: null, claude_model: 'claude-haiku-4-5-20251001', gemini_model: 'gemini-2.0-flash' });
const settingsForm = reactive({ ai_provider: 'claude', anthropic_api_key: '', gemini_api_key: '', claude_model: 'claude-haiku-4-5-20251001', gemini_model: 'gemini-2.0-flash' });
const settingsSaving = ref(false);
const settingsTesting = ref(false);
const settingsSaved = ref(false);
const testResult = ref(null);

const rForm = reactive({ titre: '', description: '', type: 'cours', filiere: '', niveau: '', fichier: null });
const qForm = reactive({ titre: '', matiere: '', chapitre: '', filiere: '', niveau: '', questions: [{ question: '', optionsText: '', bonne_reponse: '' }] });
const aForm = reactive({ titre: '', description: '' });

const filiereStats = computed(() => {
  const map = {};
  etudiants.value.forEach(e => {
    const f = e.etudiant?.filiere || 'Non defini';
    map[f] = (map[f] || 0) + 1;
  });
  return map;
});

const maxFiliere = computed(() => Math.max(...Object.values(filiereStats.value), 1));

const filteredEtudiants = computed(() => {
  if (!searchQuery.value) return etudiants.value;
  const q = searchQuery.value.toLowerCase();
  return etudiants.value.filter(e =>
    `${e.prenom} ${e.nom} ${e.email} ${e.etudiant?.matricule} ${e.etudiant?.filiere}`.toLowerCase().includes(q)
  );
});

function buildChart() {
  nextTick(() => {
    if (!chartEl.value) return;
    if (chartInstance) chartInstance.destroy();
    const months = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun'];
    const data = months.map(() => Math.floor(Math.random() * 8) + 1);
    chartInstance = new Chart(chartEl.value, {
      type: 'bar',
      data: {
        labels: months,
        datasets: [{
          label: 'Inscriptions',
          data: data,
          backgroundColor: ['#6366f1', '#8b5cf6', '#a78bfa', '#6366f1', '#8b5cf6', '#a78bfa'],
          borderRadius: 8,
          borderSkipped: false,
          barThickness: 32,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' }, border: { display: false } },
          x: { grid: { display: false }, border: { display: false } }
        }
      }
    });
  });
}

watch(tab, (val) => {
  if (val === 'dashboard') buildChart();
  if (val === 'whatsapp') {
    fetchWhatsAppStatus();
    waPolling.value = setInterval(fetchWhatsAppStatus, 3000);
  } else {
    if (waPolling.value) { clearInterval(waPolling.value); waPolling.value = null; }
  }
});

onUnmounted(() => {
  if (waPolling.value) clearInterval(waPolling.value);
});

onMounted(async () => {
  try {
    const [s, e, k, st] = await Promise.all([api.get('/admin/stats'), api.get('/admin/etudiants'), api.get('/admin/knowledge'), api.get('/admin/settings')]);
    stats.value = { ...stats.value, ...s.data };
    etudiants.value = e.data;
    knowledgeDocs.value = k.data;
    aiSettings.value = st.data;
    settingsForm.ai_provider = st.data.provider;
    settingsForm.claude_model = st.data.claude_model;
    settingsForm.gemini_model = st.data.gemini_model;
  } catch {}
  buildChart();
});

function goToDashboard() { router.push('/dashboard'); }
function handleLogout() { auth.logout(); router.push('/login'); }

async function deleteUser(id) {
  if (!confirm('Supprimer cet etudiant ?')) return;
  await api.delete(`/admin/users/${id}`);
  etudiants.value = etudiants.value.filter(e => e.id !== id);
  stats.value.etudiants--;
}

async function addRessource() {
  const fd = new FormData();
  Object.entries(rForm).forEach(([k, v]) => { if (v) fd.append(k, v); });
  try {
    await api.post('/admin/ressources', fd);
    showRessourceForm.value = false;
    stats.value.ressources++;
  } catch (e) {
    alert('Erreur: ' + (e.response?.data?.message || JSON.stringify(e.response?.data?.errors) || 'Erreur inconnue'));
  }
}

async function addQuiz() {
  const payload = { ...qForm, questions: qForm.questions.map(q => ({ question: q.question, options: q.optionsText.split('|').map(o => o.trim()), bonne_reponse: q.bonne_reponse })) };
  await api.post('/admin/quizzes', payload);
  showQuizForm.value = false;
  stats.value.quizzes++;
}

async function addActualite() {
  await api.post('/admin/actualites', { ...aForm, date_publication: new Date().toISOString().split('T')[0] });
  showActuForm.value = false;
  stats.value.actualites++;
}

async function addKnowledge() {
  const fd = new FormData();
  fd.append('titre', kForm.titre);
  fd.append('fichier', kForm.fichier);
  if (kForm.matiere) fd.append('matiere', kForm.matiere);
  if (kForm.filiere) fd.append('filiere', kForm.filiere);
  if (kForm.niveau) fd.append('niveau', kForm.niveau);
  if (kForm.contenu_additionnel) fd.append('contenu_additionnel', kForm.contenu_additionnel);
  const { data } = await api.post('/admin/knowledge', fd);
  knowledgeDocs.value.unshift(data);
  showKnowledgeForm.value = false;
  kForm.titre = ''; kForm.matiere = ''; kForm.filiere = ''; kForm.niveau = ''; kForm.fichier = null; kForm.contenu_additionnel = '';
}

async function deleteKnowledge(id) {
  if (!confirm('Supprimer ce document de la base de connaissances ?')) return;
  await api.delete(`/admin/knowledge/${id}`);
  knowledgeDocs.value = knowledgeDocs.value.filter(d => d.id !== id);
}

const WA_BOT_URL = 'http://localhost:3002';

async function fetchWhatsAppStatus() {
  try {
    const res = await fetch(`${WA_BOT_URL}/status`);
    whatsappStatus.value = await res.json();
  } catch {
    whatsappStatus.value = { status: 'offline', qr: null, phone: null, name: null };
  }
}

async function restartWhatsApp() {
  try { await fetch(`${WA_BOT_URL}/restart`, { method: 'POST' }); } catch {}
  setTimeout(fetchWhatsAppStatus, 2000);
}

async function logoutWhatsApp() {
  if (!confirm('Deconnecter le bot WhatsApp ?')) return;
  try { await fetch(`${WA_BOT_URL}/logout`, { method: 'POST' }); } catch {}
  setTimeout(fetchWhatsAppStatus, 2000);
}

async function saveSettings() {
  settingsSaving.value = true;
  try {
    const { data } = await api.put('/admin/settings', settingsForm);
    aiSettings.value = data.settings;
    settingsSaved.value = true;
    setTimeout(() => { settingsSaved.value = false; }, 3000);
  } catch (e) {
    alert('Erreur lors de la sauvegarde: ' + (e.response?.data?.message || 'Erreur inconnue'));
  }
  settingsSaving.value = false;
}

async function testAi() {
  settingsTesting.value = true;
  testResult.value = null;
  try {
    const { data } = await api.post('/admin/settings/test');
    testResult.value = data;
  } catch (e) {
    testResult.value = { success: false, provider: settingsForm.ai_provider, response: 'Erreur de connexion au serveur' };
  }
  settingsTesting.value = false;
}
</script>

<style scoped>
/* ========== SHELL ========== */
.admin-shell { display: flex; min-height: 100vh; background: #f8fafc; font-family: 'Inter', -apple-system, sans-serif; }

/* ========== SIDEBAR ========== */
.sidebar {
  width: 260px; background: #0f172a; color: #fff; display: flex; flex-direction: column;
  position: fixed; height: 100vh; z-index: 100; transition: width 0.3s ease;
  box-shadow: 4px 0 24px rgba(0,0,0,0.08);
}
.sidebar.collapsed { width: 72px; }
.sidebar.collapsed .menu-text,
.sidebar.collapsed .logo-text,
.sidebar.collapsed .logo-sub,
.sidebar.collapsed .menu-label { display: none; }
.sidebar.collapsed .sidebar-logo { justify-content: center; }
.sidebar.collapsed .menu-item { justify-content: center; padding: 0.85rem; }
.sidebar.collapsed .menu-icon { margin: 0; }

.sidebar-header { padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06); }
.sidebar-logo { display: flex; align-items: center; gap: 12px; }
.logo-circle {
  width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
  background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; flex-shrink: 0;
}
.logo-text { font-size: 1.1rem; font-weight: 700; letter-spacing: 0.5px; }
.logo-sub { font-size: 0.7rem; color: #94a3b8; margin-top: 2px; }

.sidebar-menu { flex: 1; padding: 1rem 0; overflow-y: auto; }
.menu-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1.5px; color: #475569; padding: 0.5rem 1.5rem; margin-bottom: 0.3rem; }
.menu-item {
  display: flex; align-items: center; gap: 12px; padding: 0.75rem 1.5rem; color: #94a3b8;
  cursor: pointer; transition: all 0.2s; font-size: 0.88rem; border-left: 3px solid transparent; text-decoration: none;
}
.menu-item:hover { background: rgba(255,255,255,0.04); color: #e2e8f0; }
.menu-item.active { background: rgba(99,102,241,0.15); color: #fff; border-left-color: #6366f1; }
.menu-item.logout:hover { color: #f87171; }
.menu-icon { display: flex; align-items: center; flex-shrink: 0; }

.sidebar-footer { border-top: 1px solid rgba(255,255,255,0.06); padding: 0.5rem 0; }

/* ========== TOP BAR ========== */
.admin-body { flex: 1; margin-left: 260px; transition: margin-left 0.3s ease; }
.sidebar.collapsed ~ .admin-body { margin-left: 72px; }

.topbar {
  background: #fff; padding: 0 2rem; height: 64px; display: flex; align-items: center;
  justify-content: space-between; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 50;
}
.topbar-left { display: flex; align-items: center; gap: 16px; }
.toggle-btn { background: none; border: none; cursor: pointer; color: #64748b; padding: 6px; border-radius: 8px; display: flex; }
.toggle-btn:hover { background: #f1f5f9; }
.page-title { font-size: 1.2rem; font-weight: 600; color: #0f172a; }
.topbar-right { display: flex; align-items: center; gap: 20px; }
.topbar-date { font-size: 0.82rem; color: #94a3b8; }
.topbar-user { display: flex; align-items: center; gap: 10px; }
.user-avatar {
  width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem;
}
.user-info { }
.user-name { font-size: 0.85rem; font-weight: 600; color: #1e293b; }
.user-role { font-size: 0.72rem; color: #94a3b8; }

/* ========== CONTENT ========== */
.admin-content { padding: 1.5rem 2rem; }

/* ========== STAT CARDS ========== */
.stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1rem; }
.stat-card {
  border-radius: 16px; padding: 1.5rem; color: #fff; position: relative; overflow: hidden;
  display: flex; flex-direction: column; justify-content: space-between; min-height: 120px;
}
.grad-purple { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.grad-pink { background: linear-gradient(135deg, #ec4899, #f43f5e); }
.grad-blue { background: linear-gradient(135deg, #3b82f6, #06b6d4); }
.grad-green { background: linear-gradient(135deg, #10b981, #34d399); }

.stat-card-body { position: relative; z-index: 2; }
.stat-number { font-size: 2.5rem; font-weight: 800; line-height: 1; }
.stat-label { font-size: 0.85rem; opacity: 0.9; margin-top: 6px; }
.stat-card-icon { position: absolute; right: 20px; top: 20px; }
.stat-card-trend { font-size: 0.75rem; opacity: 0.8; display: flex; align-items: center; gap: 4px; margin-top: 12px; }

/* Mini stats */
.stat-row-sm { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
.mini-stat {
  background: #fff; border-radius: 12px; padding: 1rem 1.2rem; display: flex; align-items: center;
  gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); border: 1px solid #f1f5f9;
}
.mini-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.mini-label { font-size: 0.78rem; color: #64748b; }
.mini-value { font-size: 1.3rem; font-weight: 700; color: #0f172a; }

/* ========== CARDS ========== */
.card {
  background: #fff; border-radius: 12px; border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,0.04); overflow: hidden; margin-bottom: 1rem;
}
.card-head {
  padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;
  display: flex; align-items: center; justify-content: space-between;
}
.card-head h3 { font-size: 0.95rem; font-weight: 600; color: #0f172a; margin: 0; }

/* ========== CHART ========== */
.chart-wrap { padding: 1rem 1.5rem; height: 280px; }

/* ========== GRID ========== */
.grid-2-1 { display: grid; grid-template-columns: 1.6fr 1fr; gap: 1rem; margin-bottom: 1rem; }

/* ========== RECENT LIST ========== */
.recent-list { padding: 0.5rem 0; }
.recent-row { display: flex; align-items: center; gap: 12px; padding: 0.7rem 1.5rem; transition: background 0.15s; }
.recent-row:hover { background: #fafbfd; }
.avatar-sm {
  width: 36px; height: 36px; border-radius: 8px; color: #fff; display: flex; align-items: center;
  justify-content: center; font-size: 0.72rem; font-weight: 700; flex-shrink: 0;
}
.recent-info { flex: 1; min-width: 0; }
.recent-name { font-size: 0.88rem; font-weight: 500; color: #1e293b; }
.recent-sub { font-size: 0.75rem; color: #94a3b8; }

/* ========== FILIERE ========== */
.filiere-chart { padding: 1.2rem 1.5rem; }
.filiere-row { display: flex; align-items: center; gap: 14px; margin-bottom: 0.9rem; }
.filiere-name { width: 180px; font-size: 0.85rem; color: #475569; flex-shrink: 0; font-weight: 500; }
.filiere-track { flex: 1; height: 28px; background: #f1f5f9; border-radius: 8px; overflow: hidden; }
.filiere-fill { height: 100%; background: linear-gradient(90deg, #6366f1, #a78bfa); border-radius: 8px; transition: width 0.5s; min-width: 24px; }
.filiere-num { font-size: 0.88rem; font-weight: 700; color: #0f172a; width: 30px; text-align: right; }

/* ========== TABLE ========== */
.table-wrap { overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th {
  padding: 0.75rem 1rem; text-align: left; font-size: 0.72rem; text-transform: uppercase;
  letter-spacing: 0.5px; color: #94a3b8; font-weight: 600; border-bottom: 1px solid #f1f5f9; background: #fafbfd;
}
.data-table td { padding: 0.75rem 1rem; font-size: 0.88rem; color: #334155; border-bottom: 1px solid #f8fafc; }
.data-table tr:hover td { background: #fafbfd; }
.cell-user { display: flex; align-items: center; gap: 10px; }

/* Tags */
.tag { padding: 3px 10px; border-radius: 6px; font-size: 0.76rem; font-weight: 500; }
.tag-purple { background: #ede9fe; color: #7c3aed; font-family: monospace; }
.tag-blue { background: #dbeafe; color: #2563eb; }
.tag-green { background: #d1fae5; color: #059669; }

/* ========== SEARCH ========== */
.search-box {
  display: flex; align-items: center; gap: 8px; background: #f8fafc; border: 1px solid #e2e8f0;
  border-radius: 8px; padding: 0 12px; height: 36px;
}
.search-box input { border: none; background: none; outline: none; font-size: 0.85rem; width: 200px; color: #334155; }

/* ========== BUTTONS ========== */
.btn-primary {
  background: #6366f1; color: #fff; border: none; padding: 0.6rem 1.2rem; border-radius: 8px;
  font-size: 0.85rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center;
  gap: 6px; transition: background 0.2s;
}
.btn-primary:hover { background: #4f46e5; }
.btn-outline {
  background: none; border: 2px dashed #cbd5e1; color: #64748b; padding: 0.5rem 1rem; border-radius: 8px;
  font-size: 0.85rem; cursor: pointer; transition: 0.2s;
}
.btn-outline:hover { border-color: #6366f1; color: #6366f1; }
.btn-sm { padding: 0.35rem 0.8rem; font-size: 0.78rem; border-radius: 6px; cursor: pointer; border: none; font-weight: 500; }
.btn-danger { background: #fef2f2; color: #dc2626; }
.btn-danger:hover { background: #fee2e2; }

/* ========== FORMS ========== */
.form-body { padding: 1.5rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0.5rem; }
.form-row-3 { grid-template-columns: 1fr 1fr 1fr; }
.form-group { margin-bottom: 0.8rem; }
.form-group label { display: block; font-size: 0.8rem; font-weight: 500; color: #475569; margin-bottom: 0.3rem; }
.form-group input, .form-group select, .form-group textarea {
  width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;
  font-size: 0.88rem; color: #1e293b; background: #fff; transition: border 0.2s; box-sizing: border-box;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #6366f1; outline: none; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }

/* Questions */
.questions-section { margin-top: 1rem; }
.questions-section h4 { font-size: 0.95rem; font-weight: 600; color: #0f172a; margin-bottom: 0.8rem; }
.question-block {
  display: flex; gap: 1rem; background: #f8fafc; padding: 1rem; border-radius: 10px;
  margin-bottom: 0.8rem; border: 1px solid #f1f5f9;
}
.question-num {
  width: 36px; height: 36px; border-radius: 8px; background: #6366f1; color: #fff;
  display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;
}
.question-fields { flex: 1; }

/* ========== MISC ========== */
.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
.section-header h3 { font-size: 1.1rem; font-weight: 600; color: #0f172a; margin: 0; }
.mb-3 { margin-bottom: 1.5rem; }
.empty-state { text-align: center; color: #94a3b8; padding: 2.5rem; font-size: 0.9rem; line-height: 1.6; }

/* Knowledge base */
.knowledge-explain { padding: 1.5rem; display: flex; gap: 2rem; }
.knowledge-step { display: flex; gap: 14px; flex: 1; }
.knowledge-step p { font-size: 0.82rem; color: #64748b; margin-top: 4px; }
.knowledge-step strong { font-size: 0.9rem; color: #1e293b; }
.step-num {
  width: 32px; height: 32px; border-radius: 50%; background: #6366f1; color: #fff;
  display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;
}

/* WhatsApp */
.wa-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
.wa-status-body { padding: 1.5rem; }
.wa-status-indicator { display: flex; align-items: center; gap: 10px; font-size: 1rem; font-weight: 600; margin-bottom: 1.2rem; }
.wa-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
.wa-connected .wa-dot { background: #25D366; box-shadow: 0 0 8px rgba(37,211,102,0.5); }
.wa-qr_ready .wa-dot { background: #f59e0b; box-shadow: 0 0 8px rgba(245,158,11,0.5); animation: pulse 1.5s infinite; }
.wa-disconnected .wa-dot, .wa-offline .wa-dot { background: #94a3b8; }
@keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }
.wa-connected-info { }
.wa-phone-card { display: flex; align-items: center; gap: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 1rem; }
.wa-phone-name { font-weight: 600; color: #166534; }
.wa-phone-num { font-size: 0.85rem; color: #15803d; }
.wa-offline { }
.wa-offline p { color: #64748b; margin-bottom: 0.8rem; }
.wa-cmd { background: #0f172a; color: #e2e8f0; padding: 0.8rem 1rem; border-radius: 8px; font-family: monospace; font-size: 0.85rem; }
.wa-qr-body { padding: 1.5rem; text-align: center; }
.wa-qr-container { }
.wa-qr-img { border-radius: 12px; border: 4px solid #25D366; }
.wa-qr-hint { font-weight: 600; color: #1e293b; margin-top: 1rem; }
.wa-qr-steps { font-size: 0.8rem; color: #64748b; margin-top: 0.3rem; }
.wa-qr-success { padding: 2rem; }
.wa-qr-success p { font-size: 1.1rem; font-weight: 600; color: #166534; margin-top: 1rem; }

/* ========== SETTINGS ========== */
.settings-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
.provider-cards { display: flex; flex-direction: column; gap: 0.8rem; }
.provider-card {
  display: flex; align-items: center; gap: 14px; padding: 1.2rem; border: 2px solid #e2e8f0;
  border-radius: 12px; cursor: pointer; transition: all 0.2s; position: relative;
}
.provider-card:hover { border-color: #a5b4fc; background: #fafbff; }
.provider-card.active { border-color: #6366f1; background: #eef2ff; }
.provider-logo {
  width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center;
  justify-content: center; flex-shrink: 0;
}
.claude-logo { background: #fef3c7; color: #d97706; }
.gemini-logo { background: #dbeafe; color: #2563eb; }
.provider-info { flex: 1; }
.provider-name { font-size: 1rem; font-weight: 600; color: #1e293b; }
.provider-desc { font-size: 0.82rem; color: #64748b; margin-top: 2px; }
.provider-check { flex-shrink: 0; }
.label-with-badge { display: flex; align-items: center; gap: 8px; }
.badge-configured { font-size: 0.7rem; padding: 2px 8px; border-radius: 4px; background: #d1fae5; color: #059669; font-weight: 600; }
.badge-missing { font-size: 0.7rem; padding: 2px 8px; border-radius: 4px; background: #fef2f2; color: #dc2626; font-weight: 600; }
.form-hint { font-size: 0.75rem; color: #94a3b8; margin-top: 4px; display: block; }
.form-divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.2rem 0; }
.settings-actions { display: flex; gap: 0.8rem; }
.test-result-body { padding: 1.2rem 1.5rem; }
.test-provider { font-size: 0.88rem; color: #64748b; margin-bottom: 0.8rem; }
.test-response { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; font-size: 0.9rem; line-height: 1.6; color: #334155; white-space: pre-wrap; }
.tag-danger { background: #fef2f2; color: #dc2626; }
.toast-success {
  position: fixed; bottom: 2rem; right: 2rem; background: #059669; color: #fff;
  padding: 0.8rem 1.5rem; border-radius: 10px; display: flex; align-items: center; gap: 8px;
  font-size: 0.9rem; font-weight: 500; box-shadow: 0 8px 24px rgba(5,150,105,0.3);
  animation: slideUp 0.3s ease; z-index: 1000;
}
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

/* ========== RESPONSIVE ========== */
@media (max-width: 1024px) {
  .stat-row, .stat-row-sm { grid-template-columns: repeat(2, 1fr); }
  .grid-2-1, .settings-grid { grid-template-columns: 1fr; }
  .form-row-3 { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
  .sidebar { width: 72px; }
  .sidebar .menu-text, .sidebar .logo-text, .sidebar .logo-sub, .sidebar .menu-label { display: none; }
  .sidebar .sidebar-logo { justify-content: center; }
  .sidebar .menu-item { justify-content: center; padding: 0.85rem; }
  .admin-body { margin-left: 72px; }
  .stat-row, .stat-row-sm { grid-template-columns: 1fr; }
  .topbar { padding: 0 1rem; }
  .admin-content { padding: 1rem; }
}
</style>
