// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import LoginForm from '../components/LoginForm.vue';

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: LoginForm,
    },
    {
        path: '/admin/users',
        name: 'UserList',
        component: () => import('../components/admin/UserList.vue')
    },
    {
        path: '/home',
        name: 'Home',
        component: () => import('../components/HomePage.vue')
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_URL),
    routes,
});

export default router;
