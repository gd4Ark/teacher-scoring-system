/**
 *
 *
 * @export
 * @param {*} msg
 */
export function log(msg) {
    window.console.log(msg)
}

/**
 *
 *
 * @export
 * @param {*} start
 * @param {*} end
 * @returns {number}
 */
export function random(start, end) {
    return Math.floor(Math.random() * (end - start) + start)
}

/**
 *
 *
 * @export
 * @param {*} object
 * @returns {object}
 */
export function clone(object) {
    return JSON.parse(JSON.stringify(object))
}

/**
 *
 *
 * @export
 * @param {*} object1
 * @param {*} object2
 * @param {*} [callback=null]
 * @returns {object}
 */
export function cover(object1, object2, callback = null) {
    const a = Object.assign({}, object1)
    const b = Object.assign({}, object2)
    for (const key in a) {
        if (b[key] !== undefined) {
            if (callback) {
                callback(key, b[key])
            } else {
                a[key] = b[key]
            }
        }
    }
    return a
}

/**
 *
 *
 * @export
 * @param {*} object
 * @param {*} keys
 * @returns {newObj}
 */
export function retainKeys(object, keys) {
    const newObj = {}
    keys.forEach(key => {
        newObj[key] = object[key]
    })
    return newObj
}

/**
 *
 *
 * @export
 * @param {*} num
 * @returns {string}
 */
export function numberToW(num) {
    return num / 10000 + 'w'
}

/**
 *
 *
 * @export
 * @param {*} str
 * @returns {string}
 */
export function firstUpperCase(str) {
    const reg = /( |^)[a-z]/g
    return str.toLowerCase().replace(reg, L => L.toUpperCase())
}

/**
 *
 *
 * @export
 * @param {number} [len=32]
 * @param {number} [radix=0]
 * @returns {string}
 */
export function uuid(len = 32, radix = 0) {
    var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split(
        ''
    )
    var uuid = []
    var i
    radix = radix || chars.length
    if (len) {
        for (i = 0; i < len; i++) uuid[i] = chars[0 | (Math.random() * radix)]
    } else {
        var r
        uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-'
        uuid[14] = '4'
        for (i = 0; i < 36; i++) {
            if (!uuid[i]) {
                r = 0 | (Math.random() * 16)
                uuid[i] = chars[i === 19 ? (r & 0x3) | 0x8 : r]
            }
        }
    }
    return uuid.join('')
}
