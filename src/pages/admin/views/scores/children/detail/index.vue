<template>
  <not-sub-router :name="`${module}`">
    <s-table ref="table"
             :module="module"
             :get-data="getData" />
  </not-sub-router>
</template>
<script>
const __module = 'scoresDetail'
import sTable from './components/ScoreDetailTable'
import { mapActions, mapMutations } from 'vuex'
import syncChange from '@/common/mixins/syncChange'
export default {
  components: {
    sTable
  },
  mixins: [syncChange],
  data: () => ({
    module: __module
  }),
  async created() {
    this.setData({
      subject: {
        id: this.$route.params.sid
      },
      teacher: {
        id: this.$route.params.tid
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
