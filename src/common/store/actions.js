export default {
    async get(ctx, { module, url = null, doCommit = true }) {
        const path = url || module
        const res = await this._vm.$axios.get(
            `/${path}`,
            ctx.getters.requestData(ctx.rootState[module])
        )
        if (doCommit) {
            ctx.commit(`${module}/update`, res, {
                root: true
            })
        }
        return res
    },
    async getOptions(ctx, module) {
        const path = module + '?getOptions=1'
        const res = await this._vm.$axios.get(`/${path}`)
        ctx.commit(
            `${module}/update`,
            {
                options: res
            },
            {
                root: true
            }
        )
    },
    async add(ctx, { module, data }) {
        return await this._vm.$axios.post(`/${module}`, data)
    },
    async uploadAdd(ctx, { module, data }) {
        return await this._vm.$axios.upload(`/${module}`, data)
    },
    async update(ctx, { module, data }) {
        return await this._vm.$axios.put(`/${module}/${data.id}`, data)
    },
    async updateBatch(ctx, { module, all = 0, ids = [], data }) {
        const item =
            all === 1
                ? {
                    all
                }
                : {
                    ids
                }
        await this._vm.$axios.put(`/${module}`, {
            ...item,
            ...data
        })
    },
    async delete(crx, { module, ids }) {
        return await this._vm.$axios.delete(`/${module}`, {
            ids
        })
    },
    async resetSearchData(ctx, module) {
        ctx.commit(
            `${module}/update`,
            {
                search_data: this._vm.$v_data[module].search.data()
            },
            {
                root: true
            }
        )
    },
    async updateSearch(ctx, { module, search = [] }) {
        ctx.commit(
            `${module}/update`,
            {
                search
            },
            {
                root: true
            }
        )
    }
}
