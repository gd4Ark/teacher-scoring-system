export default {
    item: [
        {
            label: '旧密码',
            key: 'password_current',
            type: 'password',
            rules: [
                {
                    required: true,
                    trigger: 'blur'
                }
            ]
        },
        {
            label: '新密码',
            key: 'password',
            type: 'password',
            rules: [
                {
                    required: true,
                    trigger: 'blur'
                }
            ]
        },
        {
            label: '新密码',
            key: 'password_confirm',
            type: 'password',
            rules: [
                {
                    required: true,
                    trigger: 'blur'
                }
            ]
        }
    ],

    data: () => ({
        password_current: '',
        password: '',
        password_confirm: ''
    })
}
