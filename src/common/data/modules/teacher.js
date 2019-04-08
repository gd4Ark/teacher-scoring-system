export default {

    add: {
        item: [{
            label: "教师姓名",
            key: "name_list",
            type: "textarea",
            row: 20,
            placeholder: `请输入教师姓名，一行一个。`,
            disabledEvent: true,
            rules: [{
                required: true,
                trigger: 'blur',
            }]
        }, ],
        data: () => ({
            name_list: '',
        })
    },

    edit: {
        item: [{
            label: "教师姓名",
            key: "name",
            type: "text",
            rules: [{
                required: true,
                trigger: 'blur',
            }]
        }, ],
        data: () => ({
            name: '',
        })
    },

    search: {
        item: [{
            label: "编号",
            key: "id",
            type: "text",
            operation: '=',
        }, {
            label: "教师姓名",
            key: "name",
            type: "text",
            operation: 'like',
        }],
        data: () => ({
            id: '',
            name: '',
        })
    }

}