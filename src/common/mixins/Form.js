import BaseForm from '@/common/components/BaseForm'
import { warning } from '@/common/utils/message'
export default {
  components: {
    BaseForm
  },
  props: {
    formItem: Array,
    getFormData: Function,
    customSubmit: {
      type: Function,
      default: data => data
    },
    beforeSubmit: {
      type: Function,
      default: data => data
    },
    beforeVerify: {
      type: Function,
      default: data => data
    },
    successMessage: {
      type: Function,
      default: () => null
    },
    module: {
      type: String,
      default: ''
    },
    needSubmitBtn: {
      type: Boolean,
      default: true
    },
    labelWidth: {
      type: String,
      default: '85px'
    },
    submitBtnText: {
      type: String,
      default: '提交'
    },
    btnType: {
      type: String,
      default: ''
    },
    btnSize: {
      type: String,
      default: 'small'
    },
    isUpload: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    btnDisabled: false
  }),
  methods: {
    done() {
      this.btnDisabled = false
    },
    reset() {
      this.$nextTick(() => {
        this.$refs.baseForm.reset()
      })
    },
    async submit(data) {
      if (!this.beforeVerify(data)) {
        return warning('请填写正确！')
      }
      if (!this.module) {
        await this.customSubmit(data)
        this.reset()
        this.done()
        this.$emit('success')
        this.afterSuccess()
        return
      }
      this.btnDisabled = true
      data = this.beforeSubmit(data)
      await this.submiting(data)
    },
    async submiting() {
      // Placeholder
    },
    afterSuccess() {
      // Placeholder
    },
    resetForm() {
      this.$refs.baseForm.resetForm()
    }
  }
}
