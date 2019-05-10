export default {
    search: {
        item: [
            {
                label: '班级名称',
                key: 'group_id',
                type: 'select',
                filterable: true,
                option_module: 'groups',
                operation: '='
            }
        ],
        data: () => ({
            group_id: ''
        })
    }
}
