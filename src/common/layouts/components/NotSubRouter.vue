<template>
  <router-view v-if="isSubRouter"
               :key="$route.fullPath" />
  <div v-else
       class="inner-container">
    <slot />
  </div>
</template>
<script>
export default {
  name: 'NotSubRouter',
  props: {
    name: {
      type: String,
      default: ''
    },
    isSubRoute: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    isSubRouter() {
      if (this.name === '') {
        return this.isSubRoute
      }
      return this.$route.name !== this.name
    }
  }
}
</script>
