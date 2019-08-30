<template>
  <v-modal ref="modal"
           :title="title"
           :open-btn-text="openBtnText"
           :submit-btn-text='submitBtnText'
           :btn-size="btnSize"
           :btn-type="btnType"
           :btn-icon="btnIcon"
           :btn-style="btnStyle"
           :btn-disabled="btnDisabled"
           :before-open="onBeforeOpen"
           :disabled="disabled"
           @submit="baseFormSubmit"
           @open="reset">
    <baseForm slot="body"
              ref="baseForm"
              :need-reset-btn="false"
              :need-submit-btn="false"
              :form-item="formItem"
              :form-data="formData"
              @submit="submit" />
    <el-button slot="footer-middle"
               :size="respBtnSize"
               @click="resetForm">
      重置
    </el-button>
  </v-modal>
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
    openBtnText: {
      type: String,
      default: '编辑'
    },
    submitBtnText: {
      type: String,
      default: '更新'
    }
  },
  computed: {
    formData() {
      return this.getFormData ? this.getFormData() : this.current
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
  }
}
</script>
