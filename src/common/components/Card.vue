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
<style lang="scss">
.el-card {
  overflow-y: auto;
  @include no-scrollbar;
}

* + .el-card {
  margin-top: $app-padding;
}
.el-card__header {
  padding: 9px 10px;
}
.el-card__body {
  padding: 12px;
}

.card-title {
  font-size: 1.2rem;
  font-weight: normal;
}

.card-header {
  height: 30px;
  @include flex;
  align-items: center;
  justify-content: space-between;
}
</style>
