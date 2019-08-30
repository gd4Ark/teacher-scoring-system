<template>
  <not-sub-router :name="`${module}List`">
    <base-search :module="module"
                 :get-data="getData"
                 @before-change="beforeChange"
                 @after-change="afterChange" />
    <s-table ref="table"
             :module="module"
             :get-data="getData" />
  </not-sub-router>
</template>
<script>
const __module = 'students'
import BaseSearch from '@/common/components/BaseSearch'
import sTable from './components/StudentsTable'
import { mapActions, mapMutations } from 'vuex'
import syncChange from '@/common/mixins/syncChange'
export default {
  components: {
    BaseSearch,
    sTable
  },
  mixins: [syncChange],
  data: () => ({
    module: __module
  }),
  async created() {
    const parent = this.$route.meta.parent
    this.setData({
      parent,
      [parent]: {
        id: this.$route.params.id
      }
    })
  },
  methods: {
    ...mapActions(__module, ['getData']),
    ...mapMutations(__module, {
      setData: 'update'
    })
  }
}
</script>
