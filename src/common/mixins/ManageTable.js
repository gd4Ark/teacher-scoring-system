import loading from './loading'
import getData from './getData'
import ResponsiveSize from './ResponsiveSize'
import { mapActions } from 'vuex'
import { warning, success } from '@/common/utils/message'
import confirm from '@/common/utils/confirm'
export default {
    mixins: [ResponsiveSize, loading, getData],
    data: () => ({
        multipleSelection: [],
        loaded: false
    }),
    methods: {
        ...mapActions({
            delData: 'delete'
        }),
        beforeChange() {
            this.makeLoading()
        },
        afterChange() {
            this.$nextTick(() => {
                this.$refs.table.$el.querySelector(
                    '.el-table__body-wrapper'
                ).scrollTop = 0
                this.makeLoaded()
            })
        },
        handleDelete(ids) {
            if (ids.length === 0) {
                return warning('没有选中项！')
            }
            confirm({
                content: '确认删除？'
            })
                .then(() => {
                    this.delete(ids)
                })
                .catch(() => {})
        },
        async delete(ids) {
            await this.delData({
                module: this.module,
                ids
            })
            await this.getData()
            success('删除成功!')
        },
        handleSelectionChange(val) {
            this.multipleSelection = val.map(el => el.id)
        },
        async handleSortChange(val) {
            const desc = val.order === 'descending' ? 1 : 0
            const prop = val.prop || ''
            this.setOrder({
                order_by: prop,
                desc
            })
            this.beforeChange()
            await this.getData()
            this.afterChange()
        },
        renderHeader: (h, { column }) => {
            return h('i', {
                class: 'table-header-icon ' + column.label
            })
        }
    }
}
