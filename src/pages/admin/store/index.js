import Vue from 'vue'
import vuex from 'vuex'

import { fileListToObject } from '@/common/utils/readFile'

import createPersist from 'vuex-localstorage'

const modulesFiles = require.context('./modules', false, /\.js$/)
const modules = fileListToObject(modulesFiles)

import actions from './actions'
import getters from './getters'

Vue.use(vuex)

export default new vuex.Store({
    modules,
    actions,
    getters,
    plugins: [
        createPersist({
            namespace: process.env.APP_NAME + '-admin',
            initialState: {},
            // one week
            expires: 7 * 24 * 60 * 60 * 1e3
        })
    ]
})
