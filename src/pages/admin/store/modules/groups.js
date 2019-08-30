import commonState from '@/common/store/state'
import commonMutations from '@/common/store/mutations'

const module = 'groups'

const state = {
  ...commonState
}

const actions = {
  async getData(ctx, id) {
    const url = id ? module + `/${id}` : module
    return await ctx.dispatch(
      'get',
      {
        module,
        url,
        doCommit: !id
      },
      {
        root: true
      }
    )
  },
  async updateAllow(ctx, data) {
    return await this._vm.$axios.put(`/groups/allow`, data)
  }
}

const getters = {}

const mutations = {
  ...commonMutations
}

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
}
