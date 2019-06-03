export default {
    edit: {
        item: [
            {
                label: '归档名称',
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
                label: '归档名称',
                key: 'name',
                type: 'text',
                operation: '='
            }
        ],
        data: () => ({
            name: ''
        })
    }
}
