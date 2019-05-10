import config from '@/common/config'
const state = {
    device: 'desktop',
    sidebar: {
        opened: true
    },
    showAvatar: true,
    title: config.app_title + '- 后台管理'
}

const actions = {
    toggleDevice({ commit }, device) {
        commit('toggleDevice', device)
    },
    toggleSidebar({ commit, state }, opened = null) {
        commit('toggleSidebar', {
            opened: opened === null ? !state.sidebar.opened : opened
        })
    }
}

const getters = {}

const mutations = {
    toggleDevice(state, device) {
        state.device = device
    },
    toggleSidebar(state, { opened }) {
        state.sidebar.opened = opened
    }
}

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations
}
