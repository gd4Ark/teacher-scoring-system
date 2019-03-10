export default {
    async login({
        commit
    }, {
        data
    }) {
        commit('updateLogin', await this._vm.$axios.post(`/login`, data));
    },
    async checkLogin() {
        return await this._vm.$axios.post(`/checkLogin`);
    },
    async logout() {
        return await this._vm.$axios.post(`/logout`);
    },
    async updatePassword(context, {
        data
    }) {
        return await this._vm.$axios.post(`/password`, data);
    },
    async getUser({
        commit,
        state,
        getters
    }, data = null) {
        if (data && data.id !== null) {
            return await this._vm.$axios.get('/user', {
                id: data.id
            });
        }
        commit('updateUser', await this._vm.$axios.get('/user', getters.requestData(state.user)));
    },
    async resetSearchData(context, module) {
        context.commit(`update${this._vm.$util.firstUpperCase(module)}`, {
            searchData: this._vm.$vData[module].search.data(),
        });
    },
    async updateSearchKeyword(context, {
        module,
        searchKeyword = []
    }) {
        context.commit(`update${this._vm.$util.firstUpperCase(module)}`, {
            searchKeyword,
        });
    }
}