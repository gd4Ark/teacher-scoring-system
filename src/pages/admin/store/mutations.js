import mutations from "@/common/store/mutations";
export default {
    ...mutations,
    login(state, data) {
        state.login = this._vm.$util.cover(state.login, data)
    },
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
    teacher(state, data) {
        state.teacher = this._vm.$util.cover(state.teacher, data)
    },
    subject(state, data) {
        state.subject = this._vm.$util.cover(state.subject, data)
    },
}