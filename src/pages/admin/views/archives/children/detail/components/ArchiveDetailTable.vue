<template >
  <v-card v-if="loaded"
          class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
      <el-button :size="respBtnSize"
                 type="primary"
                 icon="el-icon-download"
                 @click="exportExcel">导出</el-button>
    </div>
    <v-table :loading="!loaded"
             ref="table"
             height="100%"
             :data="data"
             :columns="columns"
             :need-selection="false">
    </v-table>
  </v-card>
</template>
<script>
const __module = 'archivesDetail'
import vTable from '@/common/components/Table'
import loading from '@/common/mixins/loading'
import getData from '@/common/mixins/getData'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
import { mapState } from 'vuex'
export default {
  mixins: [ResponsiveSize, loading, getData],
  components: {
    vTable
  },
  data: () => ({
    module: __module,
    loaded: false,
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
  async created() {
    await this.getData()
    this.loaded = true
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
  },
  computed: {
    ...mapState({
      state: __module
    }),
    data() {
      return this.state.data.meta.archive
    },
    title() {
      return this.state.data.name + ' 归档明细'
    }
  }
}
</script>