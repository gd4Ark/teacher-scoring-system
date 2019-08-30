import rules from '../../rules'
export default {
  item: (() => {
    let tmp_password = ''
    return [
      {
        label: '旧密码',
        key: 'password_current',
        type: 'password',
        rules: [...rules.required({ label: '旧密码' })]
      },
      {
        label: '新密码',
        key: 'password',
        type: 'password',
        rules: [
          ...rules.required({ label: '新密码' }),
          ...rules.between({
            min: 6,
            max: 18,
            label: '新密码'
          }),
          {
            validator: (rule, value, callback) => {
              tmp_password = value
              return callback()
            },
            trigger: 'change'
          }
        ]
      },
      {
        label: '确认密码',
        key: 'password_confirmation',
        type: 'password',
        rules: [
          ...rules.required({ label: '确认密码' }),
          ...rules.between({
            min: 6,
            max: 18,
            label: '确认密码'
          }),
          {
            validator: (rule, value, callback) => {
              if (value !== tmp_password) {
                return callback(new Error('密码不一致'))
              }
              return callback()
            },
            trigger: 'blur'
          }
        ]
      }
    ]
  })(),

  data: () => ({
    password_current: '',
    password: '',
    password_confirmation: ''
  })
}
