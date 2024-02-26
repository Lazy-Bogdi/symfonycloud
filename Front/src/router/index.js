// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import LoginForm from '../components/LoginForm.vue'; // Adjust the path based on your file structure

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: LoginForm,
    },
    // Define other routes here
];

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_URL),
    routes,
});

export default router;
