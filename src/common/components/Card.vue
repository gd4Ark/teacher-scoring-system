<template>
  <el-card shadow="never">
    <div v-if="useHeader"
         slot="header"
         class="card-header">
      <h2 class="card-title">{{ title }}</h2>
      <slot name="toolbar">
      </slot>
    </div>
    <slot></slot>
  </el-card>
</template>
<script>
export default {
  name: 'Card',
  props: {
    useHeader: {
      type: Boolean,
      default: true
    },
    title: {
      type: String,
      default: ''
    }
  }
}
</script>