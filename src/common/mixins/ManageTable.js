import loading from './loading'
import {
    mapActions,
} from "vuex"
import {
    warning,
    success
} from "@/common/utils/message"
import confirm from "@/common/utils/confirm"
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
    mixins: [ResponsiveSize, loading],
    data: () => ({
        multipleSelection: [],
    }),
    methods: {
        ...mapActions({
            delData: 'delete',
        }),
        getData() {
            this.$emit("get-data")
        },
        handleDelete(ids) {
            if (ids.length === 0) {
                return warning("没有选中项！")
            }
            confirm({
                    content: "确认删除？"
                })
                .then(() => {
                    this.delete(ids)
                })
                .catch(() => {

                })
        },
        async delete(ids) {
            await this.delData({
                module: this.module,
                ids
            })
            this.getData()
            success("删除成功!")
        },
        handleSelectionChange(val) {
            this.multipleSelection = val.map(el => el.id)
        },
        handleSortChange(val) {
            const desc = val.order === "descending" ? 1 : 0
            const prop = val.prop || ""
            this.setOrder({
                order_by: prop,
                desc
            })
            this.getData()
        }
    }
}