<template>
    <div>
        <form @submit.prevent="login">
            <div>
                <label for="username">Email:</label>
                <input id="username" v-model="username" type="email" required>
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
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const router = useRouter();
const username = ref('');
const password = ref('');
const authStore = useAuthStore();

const login = async () => {
    try {
        // Adjust the resource path if necessary
        const response = await ApiService.login('login_check', {
            username: username.value,
            password: password.value
        });
        let tokens = response.data;
        // console.log(response.data);
        authStore.login(tokens);

        console.log('Login successful', response.data);
        const redirectPath = router.currentRoute.value.query.redirect || false;
        if(redirectPath != false){
            router.push(redirectPath);
        }        
        router.push({ name: 'Home' });
        // Redirect or perform some action after successful login
    } catch (error) {
        console.error('Login failed', error);
    }
};
</script>
