/**
 * 选项
 *
 * @export
 * @returns {array}
 */
export function stateOptions(hasAll = false, options = null) {
  let default_options = []
  if (options) {
    options.forEach((item, index) => {
      default_options.push({
        label: item,
        value: index
      })
    })
  } else {
    default_options = [
      {
        label: '是',
        value: 1
      },
      {
        label: '否',
        value: 0
      }
    ]
  }
  return hasAll
    ? [].concat(
      [
        {
          label: '全部',
          value: ''
        }
      ],
      default_options
    )
    : default_options
}

/**
 * 性别选项
 *
 * @export
 * @param {boolean} [hasAll=false]
 * @returns
 */
export function sexOptions(hasAll = false) {
  return stateOptions(hasAll, ['男', '女'])
}

export function getOrderStatusOptions() {
  return [
    {
      label: '生产中',
      value: 0
    },
    {
      label: '待试身',
      value: 1
    },
    {
      label: '已试身',
      value: 2
    },
    {
      label: '完成',
      value: 3
    }
  ]
}

export function getPayMethodOptions() {
  return [
    {
      label: '现金',
      value: 0
    },
    {
      label: '刷卡',
      value: 1
    },
    {
      label: '微信支付',
      value: 2
    },
    {
      label: '支付宝支付',
      value: 3
    }
  ]
}
