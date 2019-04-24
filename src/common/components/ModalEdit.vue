<template>
  <modal ref="modal"
         :title="title"
         :btn-text="btnText"
         :btn-size="btnSize"
         :btn-type="btnType"
         :btn-style="btnStyle"
         :btn-disabled="btnDisabled"
         :before-open="onBeforeOpen"
         @submit="baseFormSubmit"
         @open="reset">
    <baseForm slot="body"
              ref="baseForm"
              :use-btn="false"
              :form-item="formItem"
              :form-data="formData"
              @submit="submit" />
  </modal>
</template>
<script>
import Edit from '@/common/mixins/Edit'
import ModalForm from '@/common/mixins/ModalForm'
import { warning } from '@/common/utils/message'
export default {
  name: 'ModalEdit',
  mixins: [Edit, ModalForm],
  props: {
    title: {
      type: String,
      default: '编辑'
    },
    btnText: {
      type: String,
      default: '编辑'
    }
  },
  methods: {
    onBeforeOpen() {
      if (this.isBatch && this.ids.length === 0) {
        warning('没有选中项！')
        return false
      }
      return true
    }
  },
  computed: {
    formData() {
      return this.getFormData ? this.getFormData() : this.current
    }
  }
}
</script>