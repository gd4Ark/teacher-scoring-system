import Vue from 'vue'
import vuex from 'vuex'

import createPersist from 'vuex-localstorage'

import score from "./modules/score";
import teacher from "./modules/teacher";
import group from "./modules/group";
import subject from "./modules/subject";
import student from "./modules/student";
import course from "./modules/course";

import mutations from "./mutations";
import actions from "./actions";
import getters from "./getters";

Vue.use(vuex);

export default new vuex.Store({
    state: {
        score,
        teacher,
        group,
        subject,
        student,
        course,
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