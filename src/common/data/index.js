import login from "./modules/login";
import score from "./modules/score";
import teacher from "./modules/teacher";
import group from "./modules/group";
import subject from "./modules/subject";
import student from "./modules/student";
import teaching from "./modules/teaching";

export default {
    install(Vue) {

        Vue.prototype.$v_data = {
            login,
            score,
            teacher,
            group,
            subject,
            student,
            teaching,
        };
    }
}