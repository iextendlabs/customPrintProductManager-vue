
require('./bootstrap');

import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import router from './router.js';
import App from './layout/App.vue';

Vue.use(VueAxios, axios);

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
