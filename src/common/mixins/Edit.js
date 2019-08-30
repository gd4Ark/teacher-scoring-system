import Form from '@/common/mixins/Form'
import { success } from '@/common/utils/message'
import { mapActions } from 'vuex'
import { newFormData } from '@/common/utils'
export default {
  mixins: [Form],
  props: {
    current: Object,
    submitBtnText: {
      type: String,
      default: '更新'
    },
    ids: Array,
    isBatch: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    ...mapActions(['update', 'updateBatch', 'uploadUpdate']),
    async submiting(data) {
      const submitMethod = this.getSubmitMethod()
      submitMethod(data)
        .then(res => {
          this.done()
          const message = this.successMessage(res) || '更新成功！'
          success(message)
          this.$emit('success')
          this.afterSuccess()
        })
        .catch(() => {
          this.done()
        })
    },
    getSubmitMethod() {
      if (this.isBatch) {
        return this.batchSubmit
      } else if (this.isUpload) {
        return this.uploadSubmit
      } else {
        return this.baseSubmit
      }
    },
    async baseSubmit(data) {
      return await this.update({
        module: this.module,
        data,
        id: this.current.id
      })
    },
    async batchSubmit(data) {
      return await this.updateBatch({
        module: this.module,
        ids: this.ids,
        data
      })
    },
    async uploadSubmit(data) {
      const formData = newFormData(data)
      return await this.uploadUpdate({
        module: this.module,
        data: formData,
        id: this.current.id
      })
    }
  }
}
