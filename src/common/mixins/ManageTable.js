import simpleTable from './simpleTable'
import hasRole from './hasRole'
import { warning, success } from '@/common/utils/message'
import confirm from '@/common/utils/confirm'
import { mapActions } from 'vuex'
export default {
  mixins: [simpleTable, hasRole],
  methods: {
    ...mapActions({
      delData: 'delete'
    }),

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
        module: this.baseUrl || this.module,
        ids
      })
      await this.getData()
      success('删除成功!')
    }
  }
}
