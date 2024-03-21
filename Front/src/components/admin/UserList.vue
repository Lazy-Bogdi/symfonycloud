<template>
    <div>
        <h1>User List</h1>
        <ul>
            <li v-for="user in users" :key="user.id">
                {{ user.email }} - {{ user.roles.join(', ') }}
                <!-- Link to the user's details page -->
                <router-link :to="{ name: 'UserDetails', params: { id: user.id } }">View Details</router-link>
            </li>
        </ul>
    </div>
</template>


<script setup>
import { onMounted, ref } from 'vue';
import ApiService from '../../services/ApiService';

const users = ref([]);

onMounted(async () => {
    try {
        // ApiService.init();
        const response = await ApiService.get('/admin/users');
        // console.log(response)
        users.value = response.data;
        // console.log(users.value)
    } catch (error) {
        console.error('Error fetching users:', error);
        // Handle error, e.g., redirecting to login if unauthorized
    }
});
</script>