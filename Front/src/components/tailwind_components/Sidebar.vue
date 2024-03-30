<template>
    <div class="relative">
        <!-- Sidebar Overlay -->
        <div v-if="isOpen" @click="isOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

        <!-- Sidebar -->
        <aside :class="{ 'translate-x-0': isOpen, '-translate-x-full': !isOpen }"
            class="fixed left-0 top-0 w-64 h-full bg-gray-900 text-white transition-transform duration-300 ease-in-out z-50 overflow-y-auto">
            <div class="p-5">
                <h2 class="text-xl font-semibold">Menu</h2>
                <nav class="mt-5">
                    <ul class="space-y-2">
                        <li>
                            <router-link to="/"
                                class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                <span class="ml-3">Home</span>
                            </router-link>
                        </li>
                        <li v-if="authStore.isAuthenticated">
                            <router-link to="/admin/users"
                                class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-gray-700">
                                <!-- Add icon similar to the Home link -->
                                <span class="ml-3">Manage Users</span>
                            </router-link>
                        </li>
                        <li v-if="authStore.isAuthenticated">
                            <button @click="authStore.logout"
                                class="w-full text-left flex items-center p-2 text-base font-normal rounded-lg hover:bg-gray-700">
                                <!-- Add icon similar to the Home link -->
                                <span class="ml-3">Logout</span>
                            </button>
                        </li>
                        <li v-else>
                            <router-link to="/login"
                                class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-gray-700">
                                <!-- Add icon similar to the Home link -->
                                <span class="ml-3">Login</span>
                            </router-link>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Menu Button -->
        <button @click="isOpen = !isOpen"
            class="fixed top-5 left-5 p-2 text-white bg-gray-800 z-50 rounded-lg hover:bg-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../../stores/auth';

const authStore = useAuthStore();
const isOpen = ref(false);
</script>