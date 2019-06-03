export default {
    is_prod: process.env.NODE_ENV === 'production',
    app_name: process.env.APP_NAME,
    app_title: process.env.APP_TITLE,
    app_version: process.env.APP_VERSION,
    app_copyright: '© 2019 4Ark. 版权所有',
    dev_server_url: `http://${
        location.hostname
    }/teacher-scoring-system/server/public/`,
    server_url: `http://${location.hostname}/:82/`
}
