import commonState from '@/common/store/state'
import commonMutations from '@/common/store/mutations'

const state = {
    ...commonState
}

const actions = {}

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
