import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import YmapPlugin from 'vue-yandex-maps'

require('./bootstrap');
window.Vue = require('vue').default;
Vue.component('auth', require('./components/Auth.vue').default);
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(YmapPlugin)

import router from "./router";
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const app = new Vue({
    el: '#app',
    router,
});