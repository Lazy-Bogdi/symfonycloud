<template>
    <transition name="fade">
        <div v-if="isVisible" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <!-- Slot for icon or default icon -->
                        <slot name="icon">
                            <!-- Default Icon -->
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </slot>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <slot name="title">Confirm Action</slot>
                    </h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            <slot name="message">Are you sure you want to do this?</slot>
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button @click="confirm"
                            class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Oui
                        </button>
                        <button @click="close"
                            class="ml-3 px-4 py-2 bg-gray-200 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>


<script setup>
import { defineProps, defineEmits } from 'vue';

// Component props
const { isVisible, confirmAction } = defineProps({
    isVisible: Boolean,
    confirmAction: Function
});

// Define emits
const emit = defineEmits(['close']);

function close() {
    emit('close');
}

function confirm() {
    if (confirmAction) {
        confirmAction(); // Perform the confirm action passed in props
    }
    close(); // Then close the modal
}
</script>


<style scoped>
/* Add any additional styles for your modal */
.fade-enter-active,
.fade-leave-active {
    transition: opacity .5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active in <2.1.8 */
    {
    opacity: 0;
}
</style>