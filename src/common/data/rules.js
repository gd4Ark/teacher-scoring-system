import { validPlusNumber, validPhone } from '@/common/utils/validate'
export default {
  /**
   *
   *
   * @param {*} [{
   *         label = '',
   *         message = '',
   *         required = true,
   *         trigger = 'blur',
   *         type = null
   *     }={}]
   * @returns {array}
   */
  required({
    label = '',
    message = '',
    required = true,
    trigger = 'blur',
    type = ''
  } = {}) {
    const _message = label ? `${label}为必填` : '此字段为必填'
    message = message || _message
    const res = {
      required,
      trigger,
      message
    }
    if (type) {
      res.type = type
    }
    return [res]
  },
  /**
   *
   *
   * @param {*} [{ min = null, max = null, label = '', trigger = 'blur' }={}]
   * @returns {array}
   */
  between({ min = null, max = null, label = '', trigger = 'blur' } = {}) {
    const base_message = `${label}长度必须`
    let message = ''
    if (min && max) {
      message = `在${min}-${max}个字符之间`
    } else if (min) {
      message = `多于${min}个字符`
    } else {
      message = `少于${max}个字符`
    }
    return [
      {
        min,
        max,
        trigger,
        message: base_message + message
      }
    ]
  },
  /**
   *
   *
   * @param {*} [{ label = '', trigger = 'blur' }={}]
   * @returns {array}
   */
  plusNumber({ label = '', trigger = 'blur' } = {}) {
    return [
      {
        validator(rule, value, callback) {
          const message = `${label}必须为正数`
          if (!validPlusNumber(value)) {
            return callback(new Error(message))
          }
          return callback()
        },
        trigger
      }
    ]
  },
  /**
   *
   *
   * @param {*} [{ trigger = 'blur' }={}]
   * @returns {array}
   */
  phoneNumber({ trigger = 'blur' } = {}) {
    return [
      {
        validator(rule, value, callback) {
          if (!validPhone(value)) {
            return callback(new Error('电话格式不正确'))
          }
          return callback()
        },
        trigger
      }
    ]
  }
}
