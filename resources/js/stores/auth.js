import { reactive } from 'vue';
import api from '../api';

export const auth = reactive({
    user: JSON.parse(localStorage.getItem('insam_user') || 'null'),
    token: localStorage.getItem('insam_token'),

    get isLoggedIn() { return !!this.token; },
    get isAdmin() { return this.user?.role === 'admin'; },

    setUser(user, token) {
        this.user = user;
        this.token = token;
        localStorage.setItem('insam_user', JSON.stringify(user));
        localStorage.setItem('insam_token', token);
    },

    async logout() {
        try { await api.post('/logout'); } catch {}
        this.user = null;
        this.token = null;
        localStorage.removeItem('insam_user');
        localStorage.removeItem('insam_token');
    },

    async fetchUser() {
        try {
            const { data } = await api.get('/me');
            this.user = data;
            localStorage.setItem('insam_user', JSON.stringify(data));
        } catch { this.logout(); }
    }
});
