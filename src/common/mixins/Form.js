import BaseForm from "@/common/components/BaseForm";
export default {
    components: {
        BaseForm
    },
    props: {
        formItem: Array,
        getFormData: Function,
        beforeSubmit: {
            type: Function,
            default: data => data
        },
        beforeVerify: {
            type: Function,
            default: data => true
        },
        successMessage: {
            type: Function,
            default: data => null
        },
        module: {
            type: String,
            default: ""
        },
        useBtn: {
            type: Boolean,
            default: true
        },
        btnText: {
            type: String,
            default: "提交"
        },
        btnType: {
            type: String,
            default: ""
        },
        btnSize: {
            type: String,
            default: "small"
        },
        isUpload: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        reset() {
            setTimeout(() => {
                this.$refs.baseForm.reset()
            }, 0);
        },
        async submit(data) {
            if (!this.module) {
                return this.$emit("submit", data);
            }
            if (!this.beforeVerify(data)) {
                return;
            }
            data = this.beforeSubmit(data);
            await this.submiting(data);
        },
        async submiting(data) {

        },
        afterSuccess() {

        }
    }
}