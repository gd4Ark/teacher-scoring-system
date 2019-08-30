<template>
  <div class="hamburger-container"
       @click="toggleClick">
    <i :class="['hamburger','el-icon-ali-weibiaoti12',isActive ? 'opened' : 'hidden',device]" />
  </div>
</template>
<script>
export default {
  props: {
    isActive: {
      type: Boolean,
      default: false
    },
    device: {
      type: String,
      required: true
    }
  },
  methods: {
    toggleClick() {
      this.$emit('toggle-click')
    }
  }
}
</script>
<style lang="scss" scoped>
.hamburger {
    font-size: $header-icon-size;
    padding: $header-icon-padding;
    cursor: pointer;
    transition: transform 0.28s ease;
    &.desktop.hidden {
        transform: rotate(90deg);
    }
}
</style>
