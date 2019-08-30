import rules from '../rules'
export default {
  common: {
    item: [
      {
        label: '科目名称',
        key: 'subject_id',
        type: 'select',
        meta: {
          filterable: true,
          option_module: 'subjects'
        },
        rules: [...rules.required({ label: '科目名称' })]
      },
      {
        label: '教师姓名',
        key: 'teacher_id',
        type: 'select',
        meta: {
          filterable: true,
          option_module: 'teachers'
        },
        rules: [...rules.required({ label: '教师姓名' })]
      }
    ],
    data: () => ({
      subject_id: '',
      teacher_id: ''
    })
  }
}
