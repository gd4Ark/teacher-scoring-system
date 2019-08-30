const state = {
  data: [],
  archive: {
    id: null
  }
}

const actions = {
  async getData(ctx) {
    const id = ctx.state.archive.id
    const url = `archives/${id}`
    const res = await this._vm.$axios.get(`/${url}`)
    ctx.commit('update', res)
    return res
  }
}

const getters = {}

const mutations = {
  update(ctx, data) {
    ctx.data = data
  },
  updateArachive(ctx, data) {
    ctx.archive = data
  }
}

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
}
