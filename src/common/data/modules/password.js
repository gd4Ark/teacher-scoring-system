export default {
    item: [{
        label: "旧密码",
        key: "password_current",
        type: "password",
    }, {
        label: "新密码",
        key: "password",
        type: "password",
    }, {
        label: "新密码",
        key: "password_confirm",
        type: "password",
    }, ],

    data: () => ({
        password_current: '',
        password: '',
        password_confirm: '',
    }),
}