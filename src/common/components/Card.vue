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
  padding: $card-header-padding;
}
.el-card__body {
  padding: $card-body-padding;
}

.card-title {
  font-size: 1.2rem;
  font-weight: normal;
}

.card-header {
  height: $card-header-height;
  @include flex;
  align-items: center;
  justify-content: space-between;
}
</style>
