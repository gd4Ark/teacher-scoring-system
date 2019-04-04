export default {

    add: {
        item: [{
            label: "学生姓名",
            key: "name_list",
            type: "textarea",
            row: 20,
            placeholder: `请输入学生姓名，一行一个。\np.s：如已存在或重复将自动忽略。`,
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
            label: "学生姓名",
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
            label: "学生姓名",
            key: "name",
            type: "text",
            operation: 'like',
        }, {
            label: "是否已评",
            key: "complete",
            type: "select",
            operation: '=',
            options: [{
                    label: '全部',
                    value: '',
                },
                {
                    label: '是',
                    value: '1',
                },
                {
                    label: '否',
                    value: '0',
                }
            ]
        }],
        data: () => ({
            id: '',
            name: '',
            complete: '',
        })
    }

}