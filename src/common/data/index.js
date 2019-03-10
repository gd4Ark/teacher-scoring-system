import login from "./modules/login";
import tearcher from "./modules/tearcher";
import group from "./modules/group";

export default {
    install(Vue) {

        Vue.prototype.$vData = {
            login,
            tearcher,
            group,
        };
    }
}