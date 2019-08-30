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
           :disabled="disabled"
           @submit="baseFormSubmit"
           @open="reset">
    <baseForm slot="body"
              ref="baseForm"
              :need-reset-btn="false"
              :need-submit-btn="false"
              :form-item="formItem"
              :get-form-data="getFormData"
              @submit="submit" />
    <el-button slot="footer-middle"
               :size="respBtnSize"
               @click="resetForm">
      重置
    </el-button>
  </v-modal>
</template>
<script>
import Add from '@/common/mixins/Add'
import ModalForm from '@/common/mixins/ModalForm'
export default {
  name: 'ModalAdd',
  mixins: [Add, ModalForm],
  props: {
    title: {
      type: String,
      default: '添加'
    },
    openBtnText: {
      type: String,
      default: '添加'
    },
    submitBtnText: {
      type: String,
      default: '添加'
    },
    btnType: {
      type: String,
      default: 'primary'
    }
  }
}
</script>
