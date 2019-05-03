import commonState from "@/common/store/state"
import commonMutations from "@/common/store/mutations"

const state = {
    ...commonState,
}

const actions = {
    async getData(ctx) {
        const module = 'scores'
        const url = module
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: true,
        }, {
            root: true
        })
    }
}

const getters = {

}

const mutations = {
    ...commonMutations,
}

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
}