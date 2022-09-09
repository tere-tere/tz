import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler';
import Viewautopark from "./componets/ViewAutoPark.vue";
import Administration from './componets/Administration.vue';
import Alpine from 'alpinejs';
import axios from 'axios';
window.Alpine = Alpine;

Alpine.start();


const el_app = document.querySelector("#app");
const app = createApp({});

app.component(
    'Viewautopark',
    Viewautopark
);

app.component(

    'Administration',
    Administration,
);

app.mount(el_app);


