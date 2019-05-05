<template>
  <common ref="common"
          parent="subject"
          name="subjectTeachings">
    <s-table v-if="loaded"
             ref="table"
             :get-data="getData" />
  </common>
</template>
<script>
import common from './common'
import Search from '@/common/components/Search'
import sTable from './components/SubjectTeachingTable'
export default {
  components: {
    common,
    sTable,
    Search
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
