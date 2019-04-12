<template>
  <router-view v-if="isSubRouter"></router-view>
  <div class="app-container"
       v-else>
    <slot> </slot>
  </div>
</template>
<script>
export default {
  name: "NotSubRouter",
  props: {
    name: {
      type: String
    }
  },
  computed: {
    isSubRouter() {
      return this.$route.name !== this.name;
    }
  }
};
</script>