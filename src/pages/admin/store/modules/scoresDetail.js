import commonState from '@/common/store/state'
import commonMutations from '@/common/store/mutations'

const module = 'scoresDetail'

const state = {
  ...commonState,
  teacher: {
    id: null
  },
  subject: {
    id: null
  }
}

const actions = {
  async getData(ctx) {
    const sid = ctx.state.subject.id
    const tid = ctx.state.teacher.id
    const url = `scores/detail/${sid}/${tid}`
    return await ctx.dispatch(
      'get',
      {
        module,
        url,
        doCommit: true
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
