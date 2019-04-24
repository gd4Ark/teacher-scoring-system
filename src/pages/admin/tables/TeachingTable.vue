<template>
  <v-card v-if="load"
          class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
      <modal-add title="添加学生"
                 :btn-size="respBtnSize"
                 :form-item="$v_data[module].add.item"
                 :get-form-data="$v_data[module].add.data"
                 :module="module"
                 :before-submit="beforeSubmit"
                 :success-message="successMessage"
                 @get-data="getData" />
      <el-button :size="respBtnSize"
                 type="danger"
                 @click="handleDelete(multipleSelection)">删除</el-button>
    </div>

    <v-table :data="state.data"
             :columns="columns"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <template slot="append">
        <el-table-column label="教师姓名"
                         align="center">
          <template slot-scope="scope">
            <span>{{ getTeacherName(scope.row.teacher_id) }}</span>
          </template>
        </el-table-column>
        <el-table-column label="所教科目"
                         align="center">
          <template slot-scope="scope">
            <span>{{ getSubjectName(scope.row.subject_id) }}</span>
          </template>
        </el-table-column>
        <el-table-column label="操作"
                         align="center"
                         min-width="140">
          <template slot-scope="scope">
            <modal-edit :title="`编辑学生 ${scope.row.name } 中`"
                        :form-item="$v_data[module].edit.item"
                        :current="scope.row"
                        :module="module"
                        btn-size="mini"
                        @get-data="getData" />
            <el-button size="mini"
                       type="danger"
                       @click="handleDelete([scope.row.id])">删除</el-button>
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
    await this.getOptions('teachers')
    await this.getOptions('subjects')
    this.loaded()
  },
  methods: {
    ...mapActions(['getOptions']),
    ...mapMutations(__module, {
      setOrder: 'update'
    }),
    beforeSubmit(data) {
      data.group_id = this.state.group_id
      return data
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
    ...mapState(['teachers', 'subjects']),
    title() {
      return `${this.state.group.name} 课程表`
    }
  }
}
</script>