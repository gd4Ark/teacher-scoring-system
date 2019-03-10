export default {
    data: () => ({
        multipleSelection: []
    }),
    methods: {
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
                ids
            });
            this.getData();
            this.$util.msg.success("删除成功!");
        },
        handleSelectionChange(val) {
            this.multipleSelection = val.map(el => el.id);
        }
    }
}