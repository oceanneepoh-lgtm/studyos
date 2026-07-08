import { createRouter, createWebHistory } from 'vue-router';
import { auth } from '../stores/auth';

const routes = [
    { path: '/', component: () => import('../pages/Home.vue') },
    { path: '/login', component: () => import('../pages/Login.vue') },
    { path: '/register', component: () => import('../pages/Register.vue') },
    { path: '/dashboard', component: () => import('../pages/Dashboard.vue'), meta: { auth: true } },
    { path: '/chat', component: () => import('../pages/Chat.vue'), meta: { auth: true } },
    { path: '/ressources', component: () => import('../pages/Ressources.vue'), meta: { auth: true } },
    { path: '/quizzes', component: () => import('../pages/Quizzes.vue'), meta: { auth: true } },
    { path: '/quizzes/:id', component: () => import('../pages/QuizPlay.vue'), meta: { auth: true } },
    { path: '/recommandations', component: () => import('../pages/Recommandations.vue'), meta: { auth: true } },
    { path: '/actualites', component: () => import('../pages/Actualites.vue') },
    { path: '/admin', component: () => import('../pages/Admin.vue'), meta: { auth: true, admin: true } },
    { path: '/profil', component: () => import('../pages/Profil.vue'), meta: { auth: true } },
];

const router = createRouter({ history: createWebHistory(), routes });

router.beforeEach((to, from, next) => {
    if (to.meta.auth && !auth.isLoggedIn) return next('/login');
    if (to.meta.admin && !auth.isAdmin) return next('/dashboard');
    next();
});

export default router;
