import { defineStore } from 'pinia';
// import { useRouter } from 'vue-router';
import router from '../router';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('authToken') || null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        login(tokens) {
            this.token = tokens.token;
            localStorage.setItem('authToken', tokens.token);
            localStorage.setItem('refreshToken', tokens.refresh_token);
            // Here, you might also want to set up your API service to use the new token
        },
        logout() {
            this.token = null;
            localStorage.removeItem('authToken');
            localStorage.removeItem('refreshToken');
            // const router = useRouter();
            router.push({ name: 'Login' });
            // Here, you might also want to reset your API service to remove the token
        },
        // Optionally, add a method to refresh the token
    },
});
