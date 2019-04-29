<template>
  <v-card class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
      <modal-add title="添加学生"
                 :btn-size='respBtnSize'
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

    <v-table :loading="!load"
             :data="state.data"
             :columns="columns"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <template slot="append">
        <el-table-column label="是否已评"
                         align="center">
          <template slot-scope="scope">
            <span :class="['status',...getStatusClassName(scope.row.complete)]"></span>
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
const __module = 'students'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import splitNameList from '@/common/mixins/splitNameList'
import successMessage from '@/common/mixins/successMessage'
import getStatusClassName from '@/common/mixins/getStatusClassName'
import { mapState, mapMutations } from 'vuex'
export default {
  mixins: [ManageTable, splitNameList, successMessage, getStatusClassName],
  components: {
    vTable,
    Pagination,
    ModalEdit,
    ModalAdd
  },
  data: () => ({
    module: __module,
    columns: [
      {
        prop: 'name',
        label: '学生姓名',
        sortable: 'custom',
        minWidth: 100
      }
    ]
  }),
  async created() {
    await this.getData()
    this.loaded()
  },
  methods: {
    ...mapMutations(__module, {
      setOrder: 'update'
    }),
    beforeSubmit(data) {
      const res = this.splitNameList(data)
      res.nameList.forEach(el => {
        el.group_id = this.$route.params.group_id
      })
      return res
    }
  },
  computed: {
    ...mapState({
      state: __module
    }),
    title() {
      return `${this.state.group.name} 学生表`
    }
  }
}
</script>