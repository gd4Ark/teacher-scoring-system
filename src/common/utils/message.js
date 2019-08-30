import { Message } from 'element-ui'

const duration = 1500

const msg = (type, message) => {
  return new Promise(resolve => {
    Message({
      message,
      type,
      duration,
      center: true,
      showClose: true,
      onClose: () => {
        resolve()
      }
    })
  })
}

/**
 *
 *
 * @export
 * @param {*} message
 * @returns
 */
export function success(message) {
  return msg('success', message)
}

/**
 *
 *
 * @export
 * @param {*} message
 * @returns {Promise}
 */
export function warning(message) {
  return msg('warning', message)
}

/**
 *
 *
 * @export
 * @param {*} message
 * @returns {Promise}
 */
export function error(message) {
  return msg('error', message)
}

/**
 *
 *
 * @export
 * @param {*} message
 * @returns {Promise}
 */
export function info(message) {
  return msg('info', message)
}
