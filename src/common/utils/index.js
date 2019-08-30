import isArray from 'lodash/isArray'
import isString from 'lodash/isString'
/**
 *
 * @export
 * @param {*} msg
 */
export function log(msg) {
  window.console.log(msg)
}

/**
 *
 * @export
 * @param {*} num
 * @returns
 */
export function numberFormat(num) {
  return num < 10 ? '0' + num : num
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
  const a = { ...object1 }
  const b = { ...object2 }
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
 * @export
 * @param {*} str
 * @returns {string}
 */
export function removeBlank(str) {
  return str
    .split('\n')
    .map(s => s.trim())
    .filter(s => s)
    .join('\n')
}

/**
 *
 *
 * @export
 * @param {*} data
 * @returns
 */
export function newFormData(data) {
  const formData = new FormData()
  Object.keys(data).forEach(key => {
    const item = data[key]
    if (isArray(item)) {
      item.forEach(subItem => {
        formData.append(`${key}[]`, subItem)
      })
    } else {
      formData.append(key, item)
    }
  })
  return formData
}

/**
 *
 *
 * @export
 * @param {*} fileObj
 * @returns
 */
export function isFile(fileObj) {
  return fileObj.constructor === File
}

/**
 *
 *
 * @export
 * @param {*} [pic=[]]
 * @returns
 */
export function patchAdjustPic(pic = []) {
  const data = {}
  if (pic.every(item => isString(item))) {
    data.old_pic = pic
    data.pic = []
  } else {
    data.old_pic = pic.filter(item => item.pre).map(item => item.url)
    data.pic = pic
      .filter(item => !item.pre)
      .map(item => (item.raw ? item.raw : item))
  }
  return data
}

/**
 *
 *
 * @export
 * @param {*} [keys=[]]
 * @param {*} data
 * @returns
 */
export function adjustPic(keys = [], data) {
  keys.forEach(key => {
    const item = data[key]
    data[key] = item.pre ? item.url : item
  })
  return data
}

/**
 *
 *
 * @export
 * @param {*} length
 * @param {*} arr
 * @param {string} [fillItem='']
 * @returns
 */
export function padArrayStart(length, arr, fillItem = '') {
  const diff = length - arr.length
  if (diff < 1) return arr
  const newArr = new Array(diff).fill(fillItem)
  return [...arr, ...newArr]
}
