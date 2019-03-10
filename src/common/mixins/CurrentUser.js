import {
    mapState
} from "vuex";
export default {
    computed: {
        ...mapState(["login"]),
        user() {
            return Object.assign({}, this.login.user);
        }
    }
}