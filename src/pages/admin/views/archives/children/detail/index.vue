<template>
  <not-sub-router :name="module">
    <s-table ref="table"
             :get-data="getData" />
  </not-sub-router>
</template>
<script>
const __module = 'archivesDetail'
import Search from '@/common/components/Search'
import sTable from './components/ArchiveDetailTable'
import { mapActions, mapMutations } from 'vuex'
import syncChange from '@/common/mixins/syncChange'
export default {
  mixins: [syncChange],
  components: {
    sTable,
    Search
  },
  data: () => ({
    module: __module
  }),
  methods: {
    ...mapActions(__module, ['getData']),
    ...mapMutations(__module, {
      setData: 'updateArachive'
    })
  },
  async created() {
    this.setData({
      id: this.$route.params.id
    })
    this.getData()
  }
}
</script>
