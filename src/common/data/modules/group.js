export default {

    base: {
        item: [{
            label: "班级名称",
            key: "name",
            type: "textarea",
            row: 20,
            placeholder: `请输入班级名称，一行一个。
如：
    16春计网专（1）班
    17春计网专（1）班
PS：如班级名称已存在或重复将自动忽略。`,
        }, ],
        data: () => ({
            name: '',
        })
    },

    student: {
        item: [{
            label: "学生姓名",
            key: "name",
            type: "textarea",
            row: 20,
            placeholder: `请输入学生姓名，一行一个。
如：
    张三
    李四
PS：如学生姓名已存在或重复将自动忽略。`,
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
            label: "班级名称",
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