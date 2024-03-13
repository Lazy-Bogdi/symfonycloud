<template>
    <div>
        <h1>Welcome to the Home Page</h1>
        <!-- Display admin links if the user is an admin -->
        <!-- <div v-if="authStore.isAdmin"> -->
            <h2>Admin Links</h2>
            <ul>
                <li><router-link to="/admin/users">Manage Users</router-link></li>
                <!-- Add more admin links as needed -->
            </ul>
        <!-- </div> -->
    </div>
</template>

<script setup>
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();
</script>