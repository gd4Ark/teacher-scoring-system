export default {

    add: {
        item: [{
            label: "科目名称",
            key: "name_list",
            type: "textarea",
            row: 20,
            placeholder: `请输入科目名称，一行一个。\np.s：如已存在或重复将自动忽略。`,
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
            label: "科目名称",
            key: "name",
            type: "text",
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
            label: "科目名称",
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