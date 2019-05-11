export default {
    add: {
        item: [
            {
                label: '班级名称',
                key: 'names',
                type: 'textarea',
                row: 20,
                placeholder: `请输入班级名称，一行一个。\np.s：如已存在或重复将自动忽略。`,
                disabledEvent: true,
                rules: [
                    {
                        required: true,
                        trigger: 'blur'
                    }
                ]
            }
        ],
        data: () => ({
            names: ''
        })
    },

    edit: {
        item: [
            {
                label: '班级名称',
                key: 'name',
                type: 'text',
                rules: [
                    {
                        required: true,
                        trigger: 'blur'
                    }
                ]
            }
        ],
        data: () => ({
            name: ''
        })
    },

    search: {
        item: [
            {
                label: '班级名称',
                key: 'name',
                type: 'text',
                operation: 'like'
            },
            {
                label: '允许评分',
                key: 'allow',
                type: 'select',
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
        ],
        data: () => ({
            name: '',
            allow: ''
        })
    }
}
