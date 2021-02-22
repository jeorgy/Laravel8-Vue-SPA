
import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth.js'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        auth
    },
    state: {
        breadcrumbList: null
    },
    mutations: {
        updateBreadcrumbList(state, breadcrumb) {
            state.breadcrumbList = breadcrumb
        }
    },
    actions: {
        updateBreadcrumbList({ commit }, breadcrumb) {
            commit('updateBreadcrumbList', breadcrumb)
        }
    },
    getters: {
        breadcrumbList(state) {
            return state.breadcrumbList
        }
    },
    strict: debug
});