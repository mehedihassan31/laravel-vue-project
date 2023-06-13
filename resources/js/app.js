import './bootstrap';
import { createApp } from 'vue';
import Home from "./components/Home.vue";
import VueCookies from 'vue-cookies';


import Toaster from '@meforma/vue-toaster';

const app = createApp({
    components:{
        Home,
    }
});
app.mount('#app');
app.use(Toaster);
app.use(VueCookies);
