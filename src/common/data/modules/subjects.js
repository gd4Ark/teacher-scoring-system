import rules from '../rules'
export default {
  add: {
    item: [
      {
        label: '名称列表',
        key: 'names',
        type: 'textarea',
        meta: {
          row: 20,
          placeholder: `请输入科目名称，一行一个。\np.s：如已存在或重复将自动忽略。`,
          disabledEvent: true
        },
        rules: [...rules.required({ label: '名称列表' })]
      }
    ],
    data: () => ({
      names: ''
    })
  },

  edit: {
    item: [
      {
        label: '名称',
        key: 'name',
        type: 'text',
        meta: {},
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
