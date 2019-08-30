export default {
  methods: {
    beforeChange() {
      this.$nextTick(() => {
        this.$refs.table.beforeChange()
      })
    },
    afterChange() {
      this.$nextTick(() => {
        this.$refs.table.afterChange()
      })
    }
  }
}
