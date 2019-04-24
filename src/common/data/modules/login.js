export default {
    item: [{
        key: "username",
        type: "text",
        placeholder: '请输入用户名',
        slot: {
            name: 'prepend',
            type: 'icon',
            value: 'el-icon-ali-ai-user',
        }
    }, {
        key: "password",
        type: "password",
        placeholder: '请输入密码',
        slot: {
            name: 'prepend',
            type: 'icon',
            value: 'el-icon-ali-mima',
        }
    }, ],

    data: () => ({
        username: '',
        password: '',
    }),
}