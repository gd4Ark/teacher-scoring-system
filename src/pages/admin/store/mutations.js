import mutations from "@/common/store/mutations";
export default {
    ...mutations,
    group(state, data) {
        state.group = this._vm.$util.cover(state.group, data)
    },
    tearcher(state, data) {
        state.tearcher = this._vm.$util.cover(state.tearcher, data)
    },
    subject(state, data) {
        state.subject = this._vm.$util.cover(state.subject, data)
    },
}