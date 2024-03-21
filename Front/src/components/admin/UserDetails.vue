<template>
    <div v-if="user" class="space-y-4">
        <h1 class="text-lg font-bold">User Details</h1>
        <div v-if="!isEditing">
            <div>Email: {{ user.email }}</div>
            <div>Roles: {{ user.roles.join(', ') }}</div>
            <button @click="isEditing = true" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Edit User</button>
        </div>
        <div v-else>
            <form @submit.prevent="openModal">
                <label class="block">Email:
                    <input type="email" v-model="editUser.email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </label>
                <!-- Add more fields for editing as needed -->
                <button type="button" @click="openModal" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Save Changes</button>
                <button @click="isEditing = false" class="mt-4 ml-2 px-4 py-2 bg-red-500 text-white rounded">Cancel</button>
            </form>
        </div>
    </div>
    <div v-else>
        Loading user details...
    </div>
    
    <ConfirmModal 
        :isVisible="showModal"
        @close="showModal = false"
        :confirmAction="confirmEdit">
        <template #title>
            Edition de l'utilisateur
        </template>
        <template #message>
            Etes-vous sûr de vos changements ?
        </template>
    </ConfirmModal>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import ApiService from '../../services/ApiService';
import ConfirmModal from '../tailwind_components/ConfirmModal.vue'; // adjust the path as necessary

const user = ref(null);
const editUser = ref({});
const isEditing = ref(false);
const showModal = ref(false);
const route = useRoute();
const userId = ref(route.params.id);

onMounted(async () => {
    try {
        const response = await ApiService.get(`/admin/users/${userId.value}`);
        user.value = response.data;
        editUser.value = { ...response.data };
    } catch (error) {
        console.error('Error fetching user details:', error);
    }
});

const openModal = () => {
    showModal.value = true;
};

const confirmEdit = async () => {
    showModal.value = false; // Close the modal
    try {
        await ApiService.put(`/admin/users/${userId.value}`, editUser.value);
        user.value = { ...editUser.value };
        isEditing.value = false;
        // Implement success notification here
    } catch (error) {
        console.error('Error updating user:', error);
        // Implement error notification here
    }
};
</script>
