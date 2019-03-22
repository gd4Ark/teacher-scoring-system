import login from "./modules/login";
import tearcher from "./modules/tearcher";
import group from "./modules/group";
import subject from "./modules/subject";
import student from "./modules/student";
import course from "./modules/course";

export default {
    install(Vue) {

        Vue.prototype.$v_data = {
            login,
            tearcher,
            group,
            subject,
            student,
            course,
        };
    }
}