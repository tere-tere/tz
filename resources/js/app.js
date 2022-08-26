import './bootstrap';
import { createApp } from 'vue'
import ViewAutoPark from './componets/ViewAutoPark.vue'
import Alpine from 'alpinejs';
import axios from 'axios';
window.Alpine = Alpine;

Alpine.start();



createApp(ViewAutoPark).mount('#app')
