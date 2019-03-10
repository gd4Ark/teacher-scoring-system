export default {

    base: {
        item: [{
            label: "姓名",
            key: "name",
            type: "textarea",
            row: 20,
            placeholder: `请输入教师姓名，一行一个。
如：
    张三
    李四 
PS：如姓名已存在或重复将自动忽略。`,
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
            label: "姓名",
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