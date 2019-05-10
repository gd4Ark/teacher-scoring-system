<template>
    <baseForm ref="baseForm"
              :btn-text="btnText"
              :btn-disabled="btnDisabled"
              :form-item="formItem"
              :form-data="current"
              @submit="submit">
        <slot />
    </baseForm>
</template>
<script>
import Edit from '@/common/mixins/Edit'
export default {
    name: 'Edit',
    mixins: [Edit]
}
</script>
