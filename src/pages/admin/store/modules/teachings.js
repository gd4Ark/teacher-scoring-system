import commonState from "@/common/store/state"
import commonMutations from "@/common/store/mutations"

const state = {
    ...commonState,
    group: null,
    group_id: '',
}

const actions = {
    async getData(ctx, id) {
        const {
            group_id
        } = ctx.state
        const module = 'teachings'
        const url = id ? module + `/${id}` : module + `?groupId=${group_id}`
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
    ...commonMutations,
}

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
}