<template>
  <common ref="common"
          parent="teacher"
          name="teacherTeachings">
    <s-table v-if="loaded"
             :get-data="getData" />
  </common>
</template>
<script>
import common from './common'
import Search from '@/common/components/Search'
import sTable from './components/TeacherTeachingTable'
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
    async getData() {
      return await this.$refs.common.getData()
    }
  }
}
</script>
