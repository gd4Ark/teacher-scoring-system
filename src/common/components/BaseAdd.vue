<template>
  <baseForm ref="baseForm"
            :need-submit-btn="needSubmitBtn"
            :submit-btn-text="submitBtnText"
            :btn-disabled="btnDisabled"
            :form-item="formItem"
            :label-width="labelWidth"
            :get-form-data="getFormData"
            @submit="submit">
    <slot />
  </baseForm>
</template>
<script>
import Add from '@/common/mixins/Add'
export default {
  name: 'BaseAdd',
  mixins: [Add]
}
</script>
