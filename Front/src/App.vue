<script setup>
import HomePage from './components/HomePage.vue';
import Sidebar from './components/tailwind_components/Sidebar.vue';
</script>

<template>
  <Sidebar />
  <div class="relative z-30"> <!-- Removed the margin-left (ml-64) -->
    <router-view></router-view>
  </div>
</template>


<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}

.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}

.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
