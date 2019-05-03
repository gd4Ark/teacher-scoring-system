<template>
  <not-sub-router :name="module">
    <search :module="module"
            @get-data="getData" />
    <s-table @get-data="getData" />
  </not-sub-router>
</template>
<script>
const __module = 'teachers'
import Search from '@/common/components/Search'
import sTable from './components/TeacherTable'
import { mapActions } from 'vuex'
export default {
  components: {
    sTable,
    Search
  },
  data: () => ({
    module: __module
  }),
  methods: {
    ...mapActions(__module, ['getData'])
  }
}
</script>
