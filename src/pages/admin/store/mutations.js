import mutations from "@/common/store/mutations";
export default {
    ...mutations,
    score(state, data) {
        state.score = this._vm.$util.cover(state.score, data)
    },
    group(state, data) {
        state.group = this._vm.$util.cover(state.group, data)
    },
    student(state, data) {
        state.student = this._vm.$util.cover(state.student, data)
    },
    teaching(state, data) {
        state.teaching = this._vm.$util.cover(state.teaching, data)
    },
    tearcher(state, data) {
        state.tearcher = this._vm.$util.cover(state.tearcher, data)
    },
    subject(state, data) {
        state.subject = this._vm.$util.cover(state.subject, data)
    },
}