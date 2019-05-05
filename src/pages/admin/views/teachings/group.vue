<template>
  <common ref="common"
          parent="group"
          name="groupTeachings">
    <s-table v-if="loaded"
             ref="table"
             :get-data="getData" />
  </common>
</template>
<script>
import common from './common'
import Search from '@/common/components/Search'
import sTable from './components/GroupTeachingTable'
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
