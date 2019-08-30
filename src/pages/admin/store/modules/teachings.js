import commonState from '@/common/store/state'
import commonMutations from '@/common/store/mutations'

const module = 'teachings'

const state = {
  ...commonState,
  parent: null,
  group: {
    id: null
  },
  teacher: {
    id: null
  },
  subject: {
    id: null
  }
}

const actions = {
  async getData(ctx, id) {
    const parent = ctx.state.parent
    const parent_id = ctx.state[parent].id
    const url = id ? module + `/${id}` : module + `?${parent}Id=${parent_id}`
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
