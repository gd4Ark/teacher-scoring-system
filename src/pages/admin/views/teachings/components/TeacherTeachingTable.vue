<template>
  <v-card :title="title"
          class="table-card">
    <v-table ref="table"
             :loading="loading"
             :data="state.data"
             :columns="columns"
             :need-selection="false"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <template slot="append">
        <el-table-column label="班级名称"
                         prop="group_id"
                         align="center">
          <template slot-scope="scope">
            <span>{{ scope.row.group_id | byOptionName(groups) }}</span>
          </template>
        </el-table-column>
        <el-table-column label="所教科目"
                         prop="subject_id"
                         align="center">
          <template slot-scope="scope">
            <span>{{ scope.row.subject_id | byOptionName(subjects) }}</span>
          </template>
        </el-table-column>
      </template>
    </v-table>

    <pagination :state="state"
                :module="module"
                :get-data="getData"
                @before-change="beforeChange"
                @after-change="afterChange" />
  </v-card>
</template>
<script>
const allOptions = ['groups', 'subjects']
import VTable from '@/common/components/VTable'
import Pagination from '@/common/components/Pagination'
import ManageTable from '@/common/mixins/ManageTable'
import getOptionName from '@/common/mixins/getOptionName'
import { mapState } from 'vuex'
export default {
  components: {
    VTable,
    Pagination
  },
  mixins: [ManageTable, getOptionName],
  props: {
    title: {
      type: String,
      default: '任课列表'
    }
  },
  data: () => ({
    columns: []
  }),
  computed: {
    ...mapState(allOptions)
  },
  async created() {
    await Promise.all([this.getData(), this.getAllOptions(allOptions)])
    this.loaded = true
    this.makeLoaded()
  }
}
</script>
