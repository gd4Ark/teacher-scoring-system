<template>
  <v-card :title="title"
          class="table-card">
    <div slot="toolbar"
         class="toolbar">
      <modal-add :btn-size="respBtnSize"
                 :form-item="$v_data[module].common.item"
                 :get-form-data="$v_data[module].common.data"
                 :before-submit="beforeSubmit"
                 :module="module"
                 title="添加任课"
                 @get-data="getData" />
      <el-button :size="respBtnSize"
                 type="danger"
                 @click="handleDelete(multipleSelection)">
        删除
      </el-button>
    </div>

    <v-table ref="table"
             :loading="loading"
             :data="state.data"
             :columns="columns"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <template slot="append">
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
        <el-table-column label="操作"
                         min-width="130"
                         align="center">
          <template slot-scope="scope">
            <modal-edit :title=" `编辑任课 ${scope.row.name} 中`"
                        :form-item="$v_data[module].common.item"
                        :current="scope.row"
                        :module="module"
                        btn-size="mini"
                        @get-data="getData" />
            <el-button size="mini"
                       type="danger"
                       @click="handleDelete([scope.row.id])">
              删除
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
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import getOptionName from '@/common/mixins/getOptionName'
import { mapState } from 'vuex'
export default {
  components: {
    VTable,
    Pagination,
    ModalEdit,
    ModalAdd
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
  },
  methods: {
    beforeSubmit(data) {
      data.group_id = this.state.group.id
      return data
    }
  }
}
</script>
