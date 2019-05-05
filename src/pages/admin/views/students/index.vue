<template>
  <not-sub-router :name="module">
    <search :module="module"
            @before-change="beforeChange"
            @after-change="afterChange"
            :get-data="getData" />
    <s-table ref="table"
             :get-data="getData" />
  </not-sub-router>
</template>
<script>
const __module = 'students'
import Search from '@/common/components/Search'
import sTable from './components/StudentTable'
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
      setData: 'update'
    })
  },
  async created() {
    const parent = this.$route.meta.parent
    this.setData({
      parent,
      [parent]: {
        id: this.$route.params.id
      }
    })
  }
}
</script>
