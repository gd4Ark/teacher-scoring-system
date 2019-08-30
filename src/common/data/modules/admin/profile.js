import rules from '../../rules'

export default {
  item: [
    {
      label: '用户名',
      key: 'name',
      type: 'text',
      rules: [...rules.required({ label: '用户名' })]
    },
    {
      label: '登陆名',
      key: 'number',
      type: 'text',
      rules: [
        ...rules.required({ label: '登陆名' }),
        ...rules.between({
          max: 16,
          label: '登陆名'
        })
      ]
    }
  ]
}
