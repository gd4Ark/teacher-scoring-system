import Modal from "@/common/components/Modal"
export default {
    components: {
        Modal
    },
    props: {
        btnStyle: {
            type: Object,
            default: () => {
                return {}
            }
        },
        btnIcon: {
            type: String,
            default: ''
        },
    },
    methods: {
        baseFormSubmit() {
            this.$refs.baseForm.submit()
        },
        afterSuccess() {
            this.$emit("get-data")
            this.$refs.modal.hidden()
        }
    }
}