import rules from '../rules'
export default {
  common: {
    item: [
      {
        label: '名称',
        key: 'name',
        type: 'text',

        rules: [...rules.required({ label: '名称' })]
      }
    ],
    data: () => ({
      name: ''
    })
  },

  search: {
    item: [
      {
        label: '编号',
        key: 'id',
        type: 'text',
        meta: {
          operation: '='
        }
      },
      {
        label: '名称',
        key: 'name',
        type: 'text',
        meta: {
          operation: 'like'
        }
      }
    ],
    data: () => ({
      id: '',
      name: ''
    })
  }
}
