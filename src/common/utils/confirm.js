import { MessageBox } from 'element-ui'

/**
 *
 *
 * @export
 * @param {*} {
 *     title = '提示',
 *     content = '确定吗？',
 *     type = 'warning'
 * }
 * @returns
 */
export default function({
  title = '提示',
  content = '确定吗？',
  type = 'warning'
}) {
  return new Promise((resolve, reject) => {
    return MessageBox.confirm(content, title, {
      confirmButtonText: '确定',
      cancelButtonText: '取消',
      type
    })
      .then(() => {
        resolve()
      })
      .catch(e => {
        reject(e)
      })
  })
}
