<template>
  <not-sub-router :name="module">
    <search :module="module"
            @get-data="getData" />
    <s-table @get-data="getData" />
  </not-sub-router>
</template>
<script>
const __module = 'students'
import Search from '@/common/components/Search'
import sTable from '@/pages/admin/tables/StudentTable'
import { mapActions, mapMutations } from 'vuex'
export default {
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
    this.setData({
      group_id: this.$route.params.group_id
    })
  }
}
</script>
