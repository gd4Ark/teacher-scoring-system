import Form from "@/common/mixins/Form"
import {
    success
} from "@/common/utils/message"
import {
    mapActions
} from "vuex"
export default {
    mixins: [Form],
    props: {
        btnText: {
            type: String,
            default: "添加"
        }
    },
    methods: {
        ...mapActions(["add", "uploadAdd"]),
        async submiting(data) {
            const submitMethod = this.isUpload ? "uploadSubmit" : "baseSubmit"
            this[submitMethod](data).then((res) => {
                this.reset()
                this.done()
                const message = this.successMessage(res) || "添加成功！"
                success(message)
                this.$emit("success")
                this.afterSuccess()
            }).catch(() => {
                this.done()
            })
        },
        async baseSubmit(data) {
            return await this.add({
                module: this.module,
                data
            })
        },
        async uploadSubmit(data) {
            const formData = new FormData()
            for (const key in data) {
                formData.append(key, data[key])
            }
            return await this.uploadAdd({
                module: this.module,
                data: formData
            })
        },
    }
}