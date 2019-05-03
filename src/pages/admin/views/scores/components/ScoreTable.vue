<template >
  <v-card class="table-card"
          :title="title">

    <v-table :loading="!load"
             :data="state.data"
             :columns="columns"
             :need-selection="false"
             @sort-change="handleSortChange">
      <template slot="prepend">
        <el-table-column label="教师姓名"
                         prop="teacher_id"
                         align="center">
          <template slot-scope="scope">
            <span>{{ getTeacherName(scope.row.teacher_id) }}</span>
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
      <template slot="append">
        <el-table-column label="操作"
                         align="center">
          <template slot-scope="scope">
            <el-button size="mini"
                       @click="toScoresDetail(scope.row.subject_id,scope.row.teacher_id)">查看明细</el-button>
          </template>
        </el-table-column>
      </template>
    </v-table>

    <pagination :state="state"
                :module="module"
                @get-data="getData" />
  </v-card>
</template>
<script>
const __module = 'scores'
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
  props: {
    title: {
      type: String,
      default: '分数表'
    }
  },
  data: () => ({
    module: __module,
    columns: [
      {
        prop: 'student_count',
        label: '评分人数',
        sortable: 'custom'
      },
      {
        prop: '教学效果',
        label: '教学效果',
        sortable: 'custom'
      },
      {
        prop: '教学水平',
        label: '教学水平',
        sortable: 'custom'
      },
      {
        prop: '教学能力',
        label: '教学能力',
        sortable: 'custom'
      },
      {
        prop: 'avg',
        label: '平均分',
        sortable: 'custom'
      }
    ]
  }),
  async created() {
    await this.getData()
    await this.getOptions('teachers')
    await this.getOptions('subjects')
    this.loaded()
  },
  methods: {
    ...mapActions(['getOptions']),
    ...mapMutations(__module, {
      setOrder: 'update'
    }),
    toScoresDetail(sid, tid) {
      this.$router.push({
        name: 'scoresDetail',
        params: {
          sid: sid,
          tid: tid
        }
      })
    },
    getTeacherName(id) {
      const item = this.teachers.options.find(el => el.value === id)
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
    ...mapState(['teachers', 'subjects'])
  }
}
</script>