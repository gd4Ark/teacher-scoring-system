import Form from '@/common/mixins/Form'
import { success } from '@/common/utils/message'
import { mapActions } from 'vuex'
import { newFormData } from '@/common/utils'
export default {
  mixins: [Form],
  props: {
    submitBtnText: {
      type: String,
      default: '添加'
    }
  },
  methods: {
    ...mapActions(['add', 'uploadAdd']),
    async submiting(data) {
      const submitMethod = this.getSubmitMethod()
      submitMethod(data)
        .then(res => {
          this.reset()
          this.done()
          const message = this.successMessage(res) || '添加成功！'
          success(message)
          this.$emit('success')
          this.afterSuccess()
        })
        .catch(() => {
          this.done()
        })
    },
    getSubmitMethod() {
      if (this.isUpload) {
        return this.uploadSubmit
      } else {
        return this.baseSubmit
      }
    },
    async baseSubmit(data) {
      return await this.add({
        module: this.module,
        data
      })
    },
    async uploadSubmit(data) {
      const formData = newFormData(data)
      return await this.uploadAdd({
        module: this.module,
        data: formData
      })
    }
  }
}
