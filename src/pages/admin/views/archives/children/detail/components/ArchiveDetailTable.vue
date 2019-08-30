<template>
  <v-card :title="title"
          class="table-card">
    <div slot="toolbar"
         class="toolbar">
      <el-button :size="respBtnSize"
                 type="primary"
                 icon="el-icon-download"
                 @click="exportExcel">
        导出
      </el-button>
    </div>

    <v-table ref="table"
             :loading="loading"
             :data="data"
             :columns="columns"
             :need-selection="false" />
  </v-card>
</template>
<script>
const allOptions = []
import VTable from '@/common/components/VTable'
import ManageTable from '@/common/mixins/ManageTable'
import getOptionName from '@/common/mixins/getOptionName'
import { mapState } from 'vuex'
export default {
  components: {
    VTable
  },
  mixins: [ManageTable, getOptionName],
  data: () => ({
    columns: [
      {
        prop: 'teacher_name',
        label: '教师名字'
      },
      {
        prop: 'subjects_name',
        label: '所教科目'
      },
      {
        prop: 'student_count',
        label: '评分人数'
      },
      {
        prop: '教学能力',
        label: '教学能力'
      },
      {
        prop: '教学水平',
        label: '教学水平'
      },
      {
        prop: '教学效果',
        label: '教学效果'
      },
      {
        prop: 'avg',
        label: '平均分'
      }
    ]
  }),
  computed: {
    ...mapState(allOptions),
    data() {
      return this.state.data.meta.archive
    },
    title() {
      return this.state.data.name + ' 归档明细'
    }
  },
  async created() {
    await Promise.all([this.getData(), this.getAllOptions(allOptions)])
    this.loaded = true
    this.makeLoaded()
  },
  methods: {
    exportExcel() {
      import('@/common/vendor/Export2Excel').then(excel => {
        const tHeader = this.columns.map(el => el.label)
        const filterVal = this.columns.map(el => el.prop)
        const data = this.formatJson(filterVal, this.data)
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: this.title
        })
      })
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v =>
        filterVal.map(j => {
          return v[j]
        })
      )
    }
  }
}
</script>
