import {
    mapActions,
} from "vuex";
export default {
    data: () => ({
        multipleSelection: []
    }),
    methods: {
        ...mapActions({
            delData: 'delete',
        }),
        getData() {
            this.$emit("get-data");
        },
        handleDelete(ids) {
            if (ids.length === 0) {
                return this.$util.msg.warning("没有选中项！");
            }
            this.$util
                .confirm({
                    content: "确认删除？"
                })
                .then(() => {
                    this.delete(ids);
                })
                .catch(() => {

                });
        },
        async delete(ids) {
            await this.delData({
                module: this.module,
                ids
            });
            this.getData();
            this.$util.msg.success("删除成功!");
        },
        handleSelectionChange(val) {
            this.multipleSelection = val.map(el => el.id);
        },
        handleSortChange(val) {
            const desc = val.order === "descending" ? 1 : 0;
            const prop = val.prop || "";
            this.setOrder({
                order_by: prop,
                desc
            });
            this.getData();
        }
    }
}