export default {
    add: {
        item: [
            {
                label: '学生姓名',
                key: 'names',
                type: 'textarea',
                row: 20,
                placeholder: `请输入学生姓名，一行一个。`,
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
                label: '学生姓名',
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
                label: '学生姓名',
                key: 'name',
                type: 'text',
                operation: 'like'
            },
            {
                label: '是否已评',
                key: 'complete',
                type: 'select',
                operation: '=',
                options: [
                    {
                        label: '全部',
                        value: ''
                    },
                    {
                        label: '是',
                        value: '1'
                    },
                    {
                        label: '否',
                        value: '0'
                    }
                ]
            }
        ],
        data: () => ({
            name: '',
            complete: ''
        })
    }
}
