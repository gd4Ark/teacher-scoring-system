import {
    Message
} from 'element-ui'

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
 * @param {*} message 
 */
export function success(message) {
    return msg('success', message)
}

/**
 * 
 * @param {*} message 
 */
export function warning(message) {
    return msg('warning', message)
}

/**
 * 
 * @param {*} message 
 */
export function error(message) {
    return msg('error', message)
}

/**
 * 
 * @param {*} message 
 */
export function info(message) {
    return msg('info', message)
}