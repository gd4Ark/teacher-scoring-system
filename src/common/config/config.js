export default {
    install(Vue) {
        Vue.prototype.$config = {
            app_name: process.env.APP_NAME,
            app_title: process.env.APP_TITLE,
            app_version: process.env.APP_VERSION,
            app_copyright: "@ 2019 4Ark. 版权所有",
            server_url: 'http://127.0.1.1/studio-admin/server/public/',
        }
    }
}