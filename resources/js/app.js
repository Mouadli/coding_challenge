require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from "bootstrap-vue"
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"

Vue.component('products-page', require('./components/products.vue').default);
Vue.use(BootstrapVue)

const app = new Vue({
    el: '#app',
});
