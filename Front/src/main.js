import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import ApiService from './services/ApiService';
import router from './router'

// Replace 'http://localhost:8000/api' with your actual Symfony API base URL
// ApiService.init('login');

createApp(App).use(router).mount('#app')
