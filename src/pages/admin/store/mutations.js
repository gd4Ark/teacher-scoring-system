import mutations from "@/common/store/mutations";
import {
    cover
} from "@/common/utils"
export default {
    ...mutations,
    login(state, data) {
        state.login = cover(state.login, data)
    },
    score(state, data) {
        state.score = cover(state.score, data)
    },
    group(state, data) {
        state.group = cover(state.group, data)
    },
    student(state, data) {
        state.student = cover(state.student, data)
    },
    teaching(state, data) {
        state.teaching = cover(state.teaching, data)
    },
    teacher(state, data) {
        state.teacher = cover(state.teacher, data)
    },
    subject(state, data) {
        state.subject = cover(state.subject, data)
    },
}