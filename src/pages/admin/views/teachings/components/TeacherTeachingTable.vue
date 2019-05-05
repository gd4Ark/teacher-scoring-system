<template>
  <v-card v-if="loaded"
          class="table-card"
          :title="title">

    <v-table :loading="loading"
             ref="table"
             :data="state.data"
             :columns="columns"
             :need-selection="false"
             @sort-change="handleSortChange">
      <template slot="append">
        <el-table-column label="班级名称"
                         prop="group_id"
                         align="center"
                         sortable="custom">
          <template slot-scope="scope">
            <span>{{ getGroupName(scope.row.group_id) }}</span>
          </template>
        </el-table-column>
        <el-table-column label="所教科目"
                         prop="subject_id"
                         align="center">
          <template slot-scope="scope">
            <span>{{ getSubjectName(scope.row.subject_id) }}</span>
          </template>
        </el-table-column>
      </template>

    </v-table>

    <pagination :state="state"
                :module="module"
                @before-change="beforeChange"
                @after-change="afterChange"
                :get-data="getData" />
  </v-card>
</template>
<script>
const __module = 'teachings'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import splitNameList from '@/common/mixins/splitNameList'
import successMessage from '@/common/mixins/successMessage'
import { mapActions, mapState, mapMutations } from 'vuex'
export default {
  mixins: [ManageTable, splitNameList, successMessage],
  components: {
    vTable,
    Pagination,
    ModalEdit,
    ModalAdd
  },
  data: () => ({
    module: __module,
    columns: []
  }),
  async created() {
    await this.getData()
    await this.getOptions('groups')
    await this.getOptions('subjects')
    this.loaded = true
    this.makeLoaded()
  },
  methods: {
    ...mapActions(['getOptions']),
    ...mapMutations(__module, {
      setOrder: 'update'
    }),
    getGroupName(id) {
      const item = this.groups.options.find(el => el.value === id)
      return item ? item.label : ''
    },
    getSubjectName(id) {
      const item = this.subjects.options.find(el => el.value === id)
      return item ? item.label : ''
    }
  },
  computed: {
    ...mapState({
      state: __module
    }),
    ...mapState(['groups', 'subjects']),
    title() {
      const parent = this.state.parent
      return this.state[parent].name + ' 任课表'
    }
  }
}
</script>