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
const __module = 'scores'
import Search from '@/common/components/Search'
import sTable from './components/ScoreTable'
import { mapActions } from 'vuex'
import syncChange from '@/common/mixins/syncChange'
export default {
  mixins: [syncChange],
  components: {
    Search,
    sTable
  },
  data: () => ({
    module: __module
  }),
  methods: {
    ...mapActions(__module, ['getData'])
  }
}
</script>