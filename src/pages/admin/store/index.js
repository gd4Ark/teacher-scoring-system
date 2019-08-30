import Vue from 'vue'
import vuex from 'vuex'

import { app_name, app_version } from '@/common/config'

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
      namespace: `${app_name}-${app_version}-admin`,
      initialState: {},
      // one day
      expires: 1 * 24 * 60 * 60 * 1e3,
    }),
  ],
})
