export default {
    is_prod: process.env.NODE_ENV == 'production',
    app_name: process.env.APP_NAME,
    app_title: process.env.APP_TITLE,
    app_version: process.env.APP_VERSION,
    app_copyright: "© 2019 4Ark. 版权所有",
    dev_server_url: 'http://127.0.0.1/teacher-scoring-system/server/public/api/',
    server_url: location.protocol + '//' + location.hostname + ':82',
}