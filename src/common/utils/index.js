/**
 *
 * @param {*} msg
 */
export function log(msg) {
    window.console.log(msg);
}
/**
 *
 * @param {*} start
 * @param {*} end
 */
export function random(start, end) {
    return Math.floor(Math.random() * (end - start) + start);
}

/**
 *
 * @param object
 * @returns {any}
 */
export function clone(object) {
    return JSON.parse(JSON.stringify(object));
}

/**
 *
 * @param object1
 * @param object2
 * @param callback
 * @returns {any}
 */
export function cover(object1, object2, callback = null) {
    const a = Object.assign({}, object1);
    const b = Object.assign({}, object2);
    for (const key in a) {
        if (b[key] !== undefined) {
            if (callback) {
                callback(key, b[key]);
            } else {
                a[key] = b[key];
            }
        }
    }
    return a;
}

/**
 *
 * @param object
 * @param keys
 * @return Object
 */
export function retainKeys(object, keys) {
    const newObj = {};
    keys.forEach(key => {
        newObj[key] = object[key];
    });
    return newObj;
}

/**
 *
 * @param num
 * @return {string}
 */
export function numberToW(num) {
    return num / 10000 + "w";
}

/**
 *
 * @param str
 * @return {string}
 */
export function firstUpperCase(str) {
    const reg = /( |^)[a-z]/g;
    return str.toLowerCase().replace(reg, L => L.toUpperCase());
}

/**
 * 指定长度和进制的UUID
 * @param len       长度
 * @param radix     进制
 * @returns {string}
 */
export function uuid(len = 32, radix = 0) {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".split(
        ""
    );
    var uuid = [],
        i;
    radix = radix || chars.length;
    if (len) {
        for (i = 0; i < len; i++) uuid[i] = chars[0 | (Math.random() * radix)];
    } else {
        var r;
        uuid[8] = uuid[13] = uuid[18] = uuid[23] = "-";
        uuid[14] = "4";
        for (i = 0; i < 36; i++) {
            if (!uuid[i]) {
                r = 0 | (Math.random() * 16);
                uuid[i] = chars[i == 19 ? (r & 0x3) | 0x8 : r];
            }
        }
    }
    return uuid.join("");
}
