<template>
  <not-sub-router :name="name">
    <slot />
  </not-sub-router>
</template>
<script>
const __module = 'teachings'
import { mapActions, mapMutations } from 'vuex'
export default {
  props: {
    parent: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: true
    }
  },
  data: () => ({
    module: __module
  }),
  async created() {
    const parent = this.parent
    this.setData({
      parent,
      [parent]: {
        id: this.$route.params.id
      }
    })
    this.getData()
  },
  methods: {
    ...mapActions(__module, ['getData']),
    ...mapMutations(__module, {
      setData: 'update'
    })
  }
}
</script>