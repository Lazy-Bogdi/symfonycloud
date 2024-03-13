import { createApp } from 'vue'
import { createPinia } from 'pinia';
import './style.css'
import App from './App.vue'
import ApiService from './services/ApiService';
import router from './router'

// Replace 'http://localhost:8000/api' with your actual Symfony API base URL
ApiService.init();

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount('#app');