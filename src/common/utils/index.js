/**
 * 
 * @param {*} msg 
 */
export function log(msg) {
    window.console.log(msg)
}
/**
 * 
 * @param {*} start 
 * @param {*} end 
 */
export function random(start, end) {
    return Math.floor(Math.random() * (end - start) + start)
}

/**
 *
 * @param object
 * @returns {any}
 */
export function clone(object) {
    return JSON.parse(JSON.stringify(object))
}

/**
 *
 * @param object1
 * @param object2
 * @param callback
 * @returns {any}
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
 * @param object
 * @param keys
 * @return Object
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
 * @param num
 * @return {string}
 */
export function numberToW(num) {
    return num / 10000 + "w"
}

/**
 * 
 * @param str
 * @return {string}
 */
export function firstUpperCase(str) {
    const reg = /( |^)[a-z]/g
    return str.toLowerCase().replace(reg, L => L.toUpperCase())
}