import Form from "@/common/mixins/Form";
import { success } from "@/common/utils/message";
import {
    mapActions
} from "vuex";
export default {
    mixins: [Form],
    props: {
        current: Object,
        btnText: {
            type: String,
            default: "更新"
        },
        ids: Array,
        isBatch: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        ...mapActions(["update", "updateBatch"]),
        async submiting(data) {
            const submitMethod = this.isBatch ? "batchSubmit" : "baseSubmit";
            const res = await this[submitMethod](data);
            if (res) {
                const message = this.successMessage(res) || "更新成功！";
                success(message);
                this.$emit("success");
                this.afterSuccess();
            }
        },
        async baseSubmit(data) {
            return await this.update({
                module: this.module,
                data: {
                    ...data,
                    id: this.current.id
                }
            });
        },
        async batchSubmit(data) {
            return await this.updateBatch({
                module: this.module,
                ids: this.ids,
                data
            });
        }
    }
}