<template>
  <baseForm ref="baseForm"
            :submit-btn-text="submitBtnText"
            :btn-disabled="btnDisabled"
            :label-width="labelWidth"
            :form-item="formItem"
            :form-data="current"
            @submit="submit">
    <slot />
  </baseForm>
</template>
<script>
import Edit from '@/common/mixins/Edit'
export default {
  name: 'BaseEdit',
  mixins: [Edit]
}
</script>
