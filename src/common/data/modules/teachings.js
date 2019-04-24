export default {

    add: {
        item: [{
            label: "教师姓名",
            key: "teacher_id",
            type: "select",
            option_module: 'teachers',
            rules: [{
                required: true,
                trigger: 'blur',
            }]
        }, {
            label: "科目名称",
            key: "subject_id",
            type: "select",
            option_module: 'subjects',
            rules: [{
                required: true,
                trigger: 'blur',
            }]
        }, ],
        data: () => ({
            teacher_id: '',
            subject_id: '',
        })
    },


    edit: {
        item: [{
            label: "教师姓名",
            key: "teacher_id",
            type: "select",
            option_module: 'teachers',
            rules: [{
                required: true,
                trigger: 'blur',
            }]
        }, {
            label: "科目名称",
            key: "subject_id",
            type: "select",
            option_module: 'subjects',
            rules: [{
                required: true,
                trigger: 'blur',
            }]
        }, ],
        data: () => ({
            teacher_id: '',
            subject_id: '',
        })
    },

}