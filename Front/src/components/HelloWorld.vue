<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();


const count = ref(0)
</script>

<template>

  <div>
        <button v-if="!authStore.isAuthenticated" @click="login">Login</button>
        <button v-else @click="authStore.logout">Logout</button>
    </div>

</template>

<style scoped>
.read-the-docs {
  color: #888;
}
</style>
