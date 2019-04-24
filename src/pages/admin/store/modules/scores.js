import commonState from "@/common/store/state"
import commonMutations from "@/common/store/mutations"
import {
    cover
} from "@/common/utils"

const state = {
    ...commonState,
}

const actions = {
    async getData(ctx, id) {
        const module = 'score'
        const url = id ? module + `/${id}` : module
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        }, {
            root: true
        })
    }
}

const getters = {

}

const mutations = {
    update: (state, data) => {
        cover(state, data, (key, val) => {
            state[key] = val
        })
    },
    ...commonMutations,
}

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
}