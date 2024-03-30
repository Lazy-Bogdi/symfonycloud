// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import LoginForm from '../components/LoginForm.vue';
import { useAuthStore } from '../stores/auth'; 

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: LoginForm,
    },
    {
        path: '/admin/users',
        name: 'UserList',
        component: () => import('../components/admin/UserList.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/admin/users/:id',
        name: 'UserDetails',
        component: () => import('../components/admin/UserDetails.vue'),
        meta: { requiresAuth: true }  // Assuming user details also require authentication
    },    
    {
        path: '/',
        name: 'Home',
        component: () => import('../components/HomePage.vue'),
        meta: { requiresAuth: true }
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_URL),
    routes,
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore(); // Use the auth store
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (requiresAuth && !authStore.isAuthenticated) {
        // Redirect the user to the login page if they are not authenticated.
        next({ name: 'Login' });
    } else {
        next(); // Go to the desired route
    }
});

export default router;
