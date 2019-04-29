<template>
  <v-card class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
    </div>

    <v-table :loading="!load"
             :data="score.list"
             :columns="columns">
      <el-table-column slot="columns-after"
                       label="操作"
                       align="center">
        <template slot-scope="scope">
          <el-button size="mini">明细</el-button>
        </template>
      </el-table-column>
    </v-table>

    <pagination :module="score"
                @get-data="getData" />
  </v-card>
</template>
<script>
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ManageTable from '@/common/mixins/ManageTable'
import { mapState } from 'vuex'
export default {
  mixins: [ManageTable],
  components: {
    vTable,
    Pagination,
    ModalEdit
  },
  props: {
    title: {
      type: String,
      default: '分数表'
    }
  },
  data: () => ({
    module: 'score',
    columns: [
      {
        prop: 'tearcher_name',
        label: '教师姓名'
      },
      {
        prop: 'subject_name',
        label: '所教科目'
      },
      {
        prop: 'score',
        label: 'xxx分数'
      },
      {
        prop: 'score',
        label: 'xxx分数'
      },
      {
        prop: 'score',
        label: 'xxx分数'
      },
      {
        prop: 'score',
        label: 'xxx分数'
      },
      {
        prop: 'count',
        label: '已评人数'
      }
    ]
  }),
  async created() {
    this.getData()
    this.loaded()
  },
  methods: {},
  computed: {
    ...mapState(['score'])
  }
}
</script>
