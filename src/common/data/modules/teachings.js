export default {

    form: {
        item: [{
            label: "科目名称",
            key: "subject_id",
            type: "select",
            filterable : true,
            option_module: 'subjects',
            rules: [{
                required: true,
                trigger: 'blur',
            }]
        }, {
            label: "教师姓名",
            key: "teacher_id",
            type: "select",
            filterable : true,
            option_module: 'teachers',
            rules: [{
                required: true,
                trigger: 'blur',
            }]
        }, ],
        data: () => ({
            subject_id: '',
            teacher_id: '',
        })
    },

}