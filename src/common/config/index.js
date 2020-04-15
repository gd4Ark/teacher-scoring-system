export const is_prod = process.env.NODE_ENV === 'production'
export const app_name = process.env.APP_NAME
export const app_title = process.env.APP_TITLE
export const app_version = process.env.APP_VERSION
export const app_copyright = 'Powered By 4Ark'
export const dev_base_url = `http://127.0.0.1/teacher-scoring-system/server/public/`
export const base_url = `http://${location.hostname}:82/admin`

export default {
  is_prod,
  app_name,
  app_title,
  app_version,
  app_copyright,
  base_url: is_prod ? base_url : dev_base_url,
}
