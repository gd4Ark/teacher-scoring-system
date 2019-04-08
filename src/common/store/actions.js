export default {
    async get(ctx, {
        module,
        url = null,
        doCommit = true,
    }) {
        const path = url ? url : module;
        const res = await this._vm.$axios.get(`/${path}`, ctx.getters.requestData(ctx.state[module]));
        if (doCommit) {
            ctx.commit(module, res);
        }
        return res;
    },
    async getOptions(ctx, module) {
        const path = module + 's' + '?getOptions=1';
        const res = await this._vm.$axios.get(`/${path}`);
        ctx.commit(module, {
            options: res
        });
    },
    async add(ctx, {
        module,
        data
    }) {
        return await this._vm.$axios.post(`/${module}s`, data);
    },
    async uploadAdd(ctx, {
        module,
        data,
    }) {
        return await this._vm.$axios.upload(`/${module}s`, data);
    },
    async update(ctx, {
        module,
        data,
    }) {
        return await this._vm.$axios.put(`/${module}s/${data.id}`, data);
    },
    async updateBatch(ctx, {
        module,
        all = 0,
        ids = [],
        data,
    }) {
        const item = all === 1 ? {
            all
        } : {
            ids
        }
        await this._vm.$axios.put(`/${module}s`, {
            ...item,
            ...data,
        })
    },
    async delete(crx, {
        module,
        ids
    }) {
        return await this._vm.$axios.delete(`/${module}s`, {
            ids
        })
    },
    async login({
        commit
    }, {
        data
    }) {
        commit('login', await this._vm.$axios.post(`/login`, data));
    },
    async checkLogin() {
        return await this._vm.$axios.post(`/checkLogin`);
    },
    async logout() {
        return await this._vm.$axios.post(`/logout`);
    },
    async resetPassword(ctx, {
        data
    }) {
        return await this._vm.$axios.post(`/reset`, data);
    },
    async resetSearchData(ctx, module) {
        ctx.commit(module, {
            search_data: this._vm.$v_data[module].search.data(),
        });
    },
    async updateSearchKeyword(ctx, {
        module,
        search_keyword = []
    }) {
        ctx.commit(module, {
            search_keyword,
        });
    }
}