import login from "./modules/login";
import password from "./modules/password";
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
            password,
            score,
            teacher,
            group,
            subject,
            student,
            teaching,
        };
    }
}