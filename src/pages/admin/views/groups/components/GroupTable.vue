<template >
  <v-card class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
      <modal-add title="添加班级"
                 :btn-size="respBtnSize"
                 :form-item="$v_data[module].add.item"
                 :get-form-data="$v_data[module].add.data"
                 :module="module"
                 :before-submit="splitNameList"
                 :success-message="successMessage"
                 @get-data="getData" />
      <el-button :size="respBtnSize"
                 type="primary"
                 @click="handleUpdateAllowBatch(1)">全部允许评分</el-button>
      <el-button :size="respBtnSize"
                 type="danger"
                 @click="handleUpdateAllowBatch(0)">全部禁止评分</el-button>
      <el-button :size="respBtnSize"
                 type="danger"
                 @click="handleDelete(multipleSelection)">删除</el-button>
    </div>

    <v-table :loading="loading"
             ref="table"
             :data="state.data"
             :columns="columns"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <template slot="append">
        <el-table-column label="评分状态"
                         align="center">
          <template slot-scope="scope">
            <el-switch v-model="scope.row.allow"
                       :active-value="1"
                       :inactive-value="0"
                       active-color="#13ce66"
                       inactive-color="#ff4949"
                       @change="handleUpdateAllow(scope.row)" />
          </template>
        </el-table-column>
        <el-table-column label="操作"
                         min-width="295"
                         align="center">
          <template slot-scope="scope">
            <el-button size="mini"
                       @click="toStudent(scope.row.id)">学生管理</el-button>
            <el-button size="mini"
                       @click="toTeaching(scope.row.id)">课程管理</el-button>
            <modal-edit :title=" `编辑班级 ${scope.row.name} 中`"
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
                @before-change="beforeChange"
                @after-change="afterChange"
                :get-data="getData" />
  </v-card>
</template>
<script>
const __module = 'groups'
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
      default: '班级表'
    }
  },
  data: () => ({
    module: __module,
    columns: [
      {
        prop: 'name',
        label: '班级名称',
        sortable: 'custom',
        minWidth: 100
      },
      {
        prop: 'students_count',
        label: '人数',
        sortable: 'custom'
      },
      {
        prop: 'complete_count',
        label: '已评人数',
        sortable: 'custom',
        minWidth: 100
      },
      {
        prop: 'teachings_count',
        label: '课程数量',
        sortable: 'custom',
        minWidth: 100
      }
    ]
  }),
  async created() {
    await this.getData()
    this.loaded = true
    this.makeLoaded()
  },
  methods: {
    ...mapActions(__module, ['updateAllow']),
    ...mapMutations(__module, {
      setOrder: 'update'
    }),
    async handleUpdateAllow(row) {
      await this.updateAllow({
        id: row.id,
        allow: row.allow
      })
      this.getData()
    },
    async handleUpdateAllowBatch(allow) {
      await this.updateAllow({
        all: 1,
        allow
      })
      await this.getData()
    },
    toStudent(id) {
      this.$router.push({
        name: 'students',
        params: {
          id
        }
      })
    },
    toTeaching(id) {
      this.$router.push({
        name: 'groupTeachings',
        params: {
          id
        }
      })
    }
  },
  computed: {
    ...mapState({
      state: __module
    })
  }
}
</script>