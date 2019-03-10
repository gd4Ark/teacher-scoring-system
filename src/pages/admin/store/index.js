import Vue from 'vue'
import vuex from 'vuex'

import createPersist from 'vuex-localstorage'

import tearcher from "./modules/tearcher";
import group from "./modules/group";

import mutations from "./mutations";
import actions from "./actions";
import getters from "./getters";

Vue.use(vuex);

export default new vuex.Store({
    state: {
        tearcher,
        group,
    },
    mutations: {
        ...mutations,
    },
    actions: {
        ...actions,
    },
    getters: {
        ...getters,
    },
    plugins: [createPersist({
        namespace: process.env.APP_NAME,
        initialState: {},
        // ONE_WEEK
        expires: 7 * 24 * 60 * 60 * 1e3
    })]
})