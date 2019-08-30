<template>
  <common ref="common"
          parent="subject"
          name="subjectTeachings">
    <s-table v-if="loaded"
             ref="table"
             :module="$refs.common.module"
             :get-data="getData" />
  </common>
</template>
<script>
import common from './common'
import sTable from './components/SubjectTeachingTable'
export default {
  components: {
    common,
    sTable
  },
  data: () => ({
    loaded: false
  }),
  mounted() {
    this.$nextTick(() => {
      this.loaded = true
    })
  },
  methods: {
    getData() {
      this.$refs.common.getData()
    }
  }
}
</script>