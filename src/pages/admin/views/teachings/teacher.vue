<template>
  <common ref="common"
          parent="teacher"
          name="teacherTeachings">
    <s-table v-if="load"
             @get-data="getData" />
  </common>
</template>
<script>
import common from './common'
import Search from '@/common/components/Search'
import sTable from './components/TeacherTeachingTable'
import loading from '@/common/mixins/loading'
export default {
  mixins: [loading],
  components: {
    common,
    sTable,
    Search
  },
  mounted() {
    this.$nextTick(() => {
      this.loaded()
    })
  },
  methods: {
    getData() {
      this.$refs.common.getData()
    }
  }
}
</script>
