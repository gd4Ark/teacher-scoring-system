<template>
  <v-card :title="title"
          class="table-card">
    <div slot="toolbar"
         class="toolbar">
      <modal-add :btn-size="respBtnSize"
                 :form-item="$v_data[module].add.item"
                 :get-form-data="$v_data[module].add.data"
                 :before-submit="beforeAddSubmit"
                 :module="module"
                 title="添加班级"
                 @get-data="getData" />
      <el-button :size="respBtnSize"
                 type="primary"
                 @click="handleUpdateAllowBatch(1)">
        全部允许评分
      </el-button>
      <el-button :size="respBtnSize"
                 type="danger"
                 @click="handleUpdateAllowBatch(0)">
        全部禁止评分
      </el-button>
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
                         min-width="230"
                         align="center">
          <template slot-scope="scope">
            <modal-edit :title=" `编辑班级 ${scope.row.name} 中`"
                        :form-item="$v_data[module].edit.item"
                        :current="scope.row"
                        :module="module"
                        btn-size="mini"
                        @get-data="getData" />
            <el-button size="mini"
                       @click="toStudent(scope.row.id)">
              学生管理
            </el-button>
            <el-button size="mini"
                       @click="toTeaching(scope.row.id)">
              课程管理
            </el-button>
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
const __module = 'groups'
const allOptions = []
import VTable from '@/common/components/VTable'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import filterName from '@/common/mixins/filterName'
import getOptionName from '@/common/mixins/getOptionName'
import { mapActions, mapState } from 'vuex'
export default {
  components: {
    VTable,
    Pagination,
    ModalEdit,
    ModalAdd
  },
  mixins: [ManageTable, filterName, getOptionName],
  props: {
    title: {
      type: String,
      default: '班级列表'
    }
  },
  data: () => ({
    columns: [
      {
        prop: 'name',
        label: '名称',
        sortable: 'custom'
      },
      {
        prop: 'teachings_count',
        label: '课程数量',
        sortable: 'custom'
      },
      {
        prop: 'students_count',
        label: '学生数量',
        sortable: 'custom'
      },
      {
        prop: 'complete_count',
        label: '完成人数',
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
    ...mapActions(__module, ['updateAllow']),
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
        name: 'studentsList',
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
  }
}
</script>
