<template>
    <div>
        <form @submit.prevent="login">
            <div>
                <label for="username">Email:</label>
                <input id="username" v-model="email" type="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" v-model="password" type="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</template>
  
<script setup>
import { ref } from 'vue';
import ApiService from '../services/ApiService';

const email = ref('');
const password = ref('');

const login = async () => {
    try {
        // Adjust the resource path if necessary
        const response = await ApiService.login('login_check', {
            username: username.value,
            password: password.value
        });
        localStorage.setItem('authToken', response.data.token);
        localStorage.setItem('refreshToken', response.data.refresh_token);

        console.log('Login successful', response.data);
        // Redirect or perform some action after successful login
    } catch (error) {
        console.error('Login failed', error);
    }
};
</script>
