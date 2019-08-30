import rules from '../../rules'
export default {
  item: [
    {
      key: 'number',
      type: 'text',
      meta: {
        placeholder: '请输入用户名',
        slot: {
          name: 'prepend',
          type: 'icon',
          value: 'el-icon-ali-ai-user'
        }
      },
      ...rules.required({ label: '用户名' })
    },
    {
      key: 'password',
      type: 'password',
      meta: {
        placeholder: '请输入密码',
        slot: {
          name: 'prepend',
          type: 'icon',
          value: 'el-icon-ali-mima'
        }
      },
      ...rules.required({ label: '密码' })
    }
  ],

  data: () => ({
    number: '',
    password: ''
  })
}
