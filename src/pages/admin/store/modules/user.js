import { cover } from '@/common/utils'

const state = {
    username: 'admin',
    access_token: ''
}

const actions = {
    async login({ commit }, { data }) {
        commit('update', await this._vm.$axios.post(`/login`, data))
    },
    async logout() {
        return await this._vm.$axios.post(`/logout`)
    },
    async resetPassword(ctx, { data }) {
        return await this._vm.$axios.post(`/reset`, data)
    }
}

const getters = {}

const mutations = {
    update: (state, data) => {
        cover(state, data, (key, val) => {
            state[key] = val
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations
}
