export default {
    updateLogin(state, data) {
        state.login = {
            ...state.login,
            ...data,
        }
    },
    updateUser(state, data) {
        state.user = {
            ...state.user,
            ...data,
        }
    },
}