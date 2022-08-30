import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler';
import Viewautopark from "./componets/ViewAutoPark.vue";
import Administration from './componets/Administration.vue';
import Alpine from 'alpinejs';
import axios from 'axios';
window.Alpine = Alpine;

Alpine.start();


// createApp({
//     el:'#app_adminstr',
    // template: "<Administration></Administration>",
    // components:
    // {
    //     Administration: Administration
    // }
// });
// const el_autopark = document.querySelector("#app_autopark");
// const el_adminstr_edit = document.querySelector("#app_adminstr_edit");
const el_app = document.querySelector("#app");


// createApp(ViewAutoPark).mount(el_autopark)
// createApp(Administration).mount(el_adminstr)


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


