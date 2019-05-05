<template>
  <div class="hamburger-container"
       @click="toggleClick">
    <i :class="['hamburger','el-icon-ali-weibiaoti12',isActive ? 'opened' : 'hidden',device]"></i>
  </div>
</template>
<script>
export default {
  props: {
    isActive: Boolean,
    device: String
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
  font-size: $hamburger-font-size;
  padding: $hamburger-padding;
  cursor: pointer;
  transition: transform 0.28s ease;
  &.desktop.hidden {
    transform: rotate(90deg);
  }
}
</style>
