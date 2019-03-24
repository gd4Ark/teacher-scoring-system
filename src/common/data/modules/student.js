export default {

    form: {
        item: [{
            label: "名字",
            key: "name",
            type: "textarea",
            row: 20,
            placeholder: `请输入名字，一行一个。\np.s：如已存在或重复将自动忽略。`,
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
            label: "名字",
            key: "name",
            type: "text",
            operation: 'like',
        }, {
            label: "是否已评",
            key: "status",
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
            status: '',
        })
    }

}