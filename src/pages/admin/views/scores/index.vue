<template>
  <not-sub-router name="index">
    <!-- <search module="score" />
    <score-table /> -->
  </not-sub-router>
</template>
<script>
import { mapActions } from 'vuex'
export default {
  components: {},
  ...mapActions({
    // getData: "getTearcher"
  })
}
</script>
