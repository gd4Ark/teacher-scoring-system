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
          placeholder: `请输入班级名称，一行一个。\np.s：如已存在或重复将自动忽略。`,
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
      },
      {
        label: '允许评分',
        key: 'allow',
        type: 'select',
        meta: {
          operation: '=',
          options: [
            {
              label: '全部',
              value: ''
            },
            {
              label: '允许',
              value: 1
            },
            {
              label: '禁止',
              value: 0
            }
          ]
        }
      }
    ],
    data: () => ({
      id: '',
      name: '',
      allow: ''
    })
  }
}
