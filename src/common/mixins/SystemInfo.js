export default {
    computed: {
        version() {
            return process.env.APP_VERSION;
        },
        title() {
            return process.env.APP_TITLE;
        },
        copyright() {
            return "@ 2019 4Ark. 版权所有";
        }
    }
}