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
const __module = 'subjects'
import BaseSearch from '@/common/components/BaseSearch'
import sTable from './components/SubjectsTable'
import { mapActions } from 'vuex'
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
  methods: {
    ...mapActions(__module, ['getData'])
  }
}
</script>
