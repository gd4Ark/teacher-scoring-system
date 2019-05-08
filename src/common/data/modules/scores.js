export default {

    archive: {
        item: [{
            label: "归档名称",
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
            key: "teacher_id",
            type: "select",
            filterable: true,
            option_module: 'teachers',
            operation: '=',
        }, {
            label: "科目名称",
            key: "subject_id",
            type: "select",
            filterable: true,
            option_module: 'subjects',
            operation: '=',
        }, ],
        data: () => ({
            teacher_id: '',
            subject_id: '',
        })
    }

}