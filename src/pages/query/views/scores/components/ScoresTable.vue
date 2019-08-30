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
      <modal-add :btn-size="respBtnSize"
                 :form-item="$v_data[module].archive.item"
                 :get-form-data="$v_data[module].archive.data"
                 :custom-submit="archive"
                 title="归档"
                 open-btn-text="归档"
                 btn-type="danger"
                 btn-icon="el-icon-ali-archives"
                 @success="archiveed"
                 @get-data="getData" />
    </div>

    <v-table ref="table"
             :loading="loading"
             :data="state.data"
             :columns="columns"
             :need-selection="false"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <template slot="prepend">
        <el-table-column label="教师姓名"
                         prop="teacher_id"
                         align="center">
          <template slot-scope="scope">
            <span>{{ scope.row.teacher_id | byOptionName(teachers) }}</span>
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
      <template slot="append">
        <el-table-column label="操作"
                         min-width="130"
                         align="center">
          <template slot-scope="scope">
            <el-button size="mini"
                       @click="toScoresDetail(scope.row)">
              查看明细
            </el-button>
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
const allOptions = ['teachers', 'subjects']
import VTable from '@/common/components/VTable'
import Pagination from '@/common/components/Pagination'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import getOptionName from '@/common/mixins/getOptionName'
import { success } from '@/common/utils/message'
import { mapState } from 'vuex'
export default {
  components: {
    VTable,
    Pagination,
    ModalAdd
  },
  mixins: [ManageTable, getOptionName],
  props: {
    title: {
      type: String,
      default: '当前分数列表'
    }
  },
  data: () => ({
    columns: [
      {
        prop: 'student_count',
        label: '评分人数',
        sortable: 'custom',
        minWidth: 100
      },
      {
        prop: '教学能力',
        label: '教学能力',
        sortable: 'custom',
        minWidth: 100
      },
      {
        prop: '教学水平',
        label: '教学水平',
        sortable: 'custom',
        minWidth: 100
      },
      {
        prop: '教学效果',
        label: '教学效果',
        sortable: 'custom',
        minWidth: 100
      },
      {
        prop: 'avg',
        label: '平均分',
        sortable: 'custom'
      }
    ]
  }),
  computed: {
    ...mapState(allOptions)
  },
  async created() {
    await Promise.all([this.getData(), this.getAllOptions(allOptions)])
    this.loaded = true
    this.makeLoaded()
  },
  methods: {
    exportExcel() {
      import('@/common/vendor/Export2Excel').then(excel => {
        const tHeader = [
          '教师名字',
          '所教科目',
          ...this.columns.map(el => el.label)
        ]
        const filterVal = [
          'subject_id',
          'teacher_id',
          ...this.columns.map(el => el.prop)
        ]
        const data = this.formatJson(filterVal, this.state.data)
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
          if (j === 'subject_id') {
            return this.getSubjectName(v[j])
          } else if (j === 'teacher_id') {
            return this.getTeacherName(v[j])
          }
          return v[j]
        })
      )
    },
    async archive(data) {
      await this.$axios.post(`/archives`, data)
      return true
    },
    async archiveed() {
      await success('归档成功！')
    },
    toScoresDetail(row) {
      this.$router.push({
        name: 'scoresDetail',
        params: {
          sid: row.subject_id,
          tid: row.teacher_id
        }
      })
    }
  }
}
</script>
