import actions from "@/common/store/actions";
export default {
    async getKeyword({
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
    async addUser(context, data) {
        return await this._vm.$axios.put('admin/user', data);
    },
    async updateUser(context, data) {
        return await this._vm.$axios.post('admin/user', data);
    },
    async updateUserPassword(context, data) {
        return await this._vm.$axios.post('admin/userPassword', data);
    },
    async delUser(context, data) {
        return await this._vm.$axios.delete('admin/user', data);
    },
    ...actions,
}