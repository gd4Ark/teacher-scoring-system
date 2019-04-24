<template>
  <modal ref="modal"
         :title="title"
         :btn-text="btnText"
         :btn-size="btnSize"
         :btn-type="btnType"
         :btn-style="btnStyle"
         :btn-disabled="btnDisabled"
         @submit="baseFormSubmit"
         @open="reset">
    <baseForm slot="body"
              ref="baseForm"
              :use-btn="false"
              :form-item="formItem"
              :get-form-data="getFormData"
              @submit="submit" />
  </modal>
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
    btnType: {
      type: String,
      default: 'primary'
    }
  }
}
</script>