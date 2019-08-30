import { numberFormat as _numberFormat } from '@/common/utils'
/**
 *
 * 10000 => "￥10,000"
 * @export
 * @param {number} [value=0]
 * @param {string} [currency='￥']
 * @param {number} [decimals=2]
 * @returns
 */
export function currency(value = 0, currency = '￥', decimals = 2) {
  const digitsRE = /(\d{3})(?=\d)/g
  value = parseFloat(value)
  const stringified = Math.abs(value).toFixed(decimals)
  const _int = decimals ? stringified.slice(0, -1 - decimals) : stringified
  const i = _int.length % 3
  const head = i > 0 ? _int.slice(0, i) + (_int.length > 3 ? ',' : '') : ''
  const _float = decimals ? stringified.slice(-1 - decimals) : ''
  const sign = value < 0 ? '-' : ''
  return (
    sign + currency + head + _int.slice(i).replace(digitsRE, '$1,') + _float
  )
}

/**
 *
 * 0 => '男'
 * @export
 * @param {*} value
 * @returns
 */
export function sex(value) {
  const sexs = ['男', '女']
  return sexs[value]
}

/**
 *
 *
 * @export
 * @param {*} num
 * @returns
 */
export function numberFormat(num) {
  return _numberFormat(num)
}

/**
 *
 * 2019-06-29 => 06
 * @export
 * @param {*} date
 * @returns
 */
export function getMonth(date) {
  const d = new Date(date)
  return numberFormat(d.getMonth() + 1)
}
