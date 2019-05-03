export default {

    add: {
        item: [{
            label: "教师姓名",
            key: "name_list",
            type: "textarea",
            row: 20,
            placeholder: `请输入教师姓名，一行一个。\np.s：如已存在或重复将自动忽略。`,
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
            label: "教师姓名",
            key: "name",
            type: "text",
            operation: 'like',
        }],
        data: () => ({
            name: '',
        })
    },

    show: {
        teaching: [{
                prop: 'subject_name',
                label: '科目名称',
            },
            {
                prop: 'group_name',
                label: '班级名称',
            },
        ]
    }

}