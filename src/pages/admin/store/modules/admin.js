import { cover } from '@/common/utils'

const state = {
  number: 'admin',
  access_token: '',
  me: {
    name: '管理员'
  }
}

const actions = {
  async login({ commit }, { data }) {
    commit('update', await this._vm.$axios.post(`/login`, data))
  },
  async logout() {
    return await this._vm.$axios.post(`/logout`)
  },
  async resetPassword(ctx, { data }) {
    return await this._vm.$axios.put(`/reset/pass`, data)
  },
  async resetProfile({ state }, { data }) {
    const id = state.me.id
    await this._vm.$axios.put(`/reset/profile/${id}`, data)
  },
  async getProfile({ state, commit }) {
    commit('updateProfile', await this._vm.$axios.get(`/me`))
  }
}

const getters = {}

const mutations = {
  update: (state, data) => {
    cover(state, data, (key, val) => {
      state[key] = val
    })
  },
  updateProfile(state, { user }) {
    state.me = {
      ...user
    }
  }
}

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
}
