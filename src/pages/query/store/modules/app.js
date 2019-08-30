import config from '@/common/config'
const state = {
  device: 'desktop',
  sidebar: {
    opened: true,
    navList: [],
    searchList: [],
  },
  root: '',
  showAvatar: false,
  title: config.app_title + '- 教师查询',
}

const actions = {
  toggleDevice({ commit }, device) {
    commit('toggleDevice', device)
  },
  toggleSidebar({ commit, state }, opened = null) {
    commit('toggleSidebar', {
      opened: opened === null ? !state.sidebar.opened : opened,
    })
  },
  updateNavList({ commit, state }, navList) {
    commit('updateNavList', {
      navList,
    })
  },
  updateSearchList({ commit, state }, searchList) {
    commit('updateSearchList', {
      searchList,
    })
  },
}

const getters = {}

const mutations = {
  toggleDevice(state, device) {
    state.device = device
  },
  toggleSidebar(state, { opened }) {
    state.sidebar.opened = opened
  },
  updateNavList(state, { navList }) {
    state.sidebar.navList = navList
  },
  updateSearchList(state, { searchList }) {
    state.sidebar.searchList = searchList
  },
  updateRoot(state, root) {
    state.root = root
  },
}

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations,
}
