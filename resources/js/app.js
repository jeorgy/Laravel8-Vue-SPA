import './bootstrap'
import 'es6-promise/auto'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import axios from 'axios'
import App from './App'
import auth from './auth'
import router from './router'
import store from './store/index'

// Set Vue globally
window.Vue = Vue

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `/api`
Vue.use(VueAuth, auth)

// Set BootstrapVue 
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

// Load App
Vue.component('app', App)
const app = new Vue({
    el: '#app',
    router,
    store
});