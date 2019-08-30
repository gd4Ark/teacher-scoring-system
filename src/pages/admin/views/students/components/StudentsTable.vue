<template>
  <v-card :title="title"
          class="table-card">
    <div slot="toolbar"
         class="toolbar">
      <modal-add :btn-size="respBtnSize"
                 :form-item="$v_data[module].add.item"
                 :get-form-data="$v_data[module].add.data"
                 :before-submit="beforeSubmit"
                 :module="module"
                 title="添加学生"
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
        <el-table-column label="是否已评"
                         align="center">
          <template slot-scope="scope">
            <span :class="['status',...getStatusClassName(scope.row.complete)]" />
          </template>
        </el-table-column>
        <el-table-column label="操作"
                         min-width="130"
                         align="center">
          <template slot-scope="scope">
            <modal-edit :title=" `编辑学生 ${scope.row.name} 中`"
                        :form-item="$v_data[module].edit.item"
                        :before-submit="beforeEditSubmit"
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
const allOptions = []
import VTable from '@/common/components/VTable'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import filterName from '@/common/mixins/filterName'
import getOptionName from '@/common/mixins/getOptionName'
import getStatusClassName from '@/common/mixins/getStatusClassName'
import { mapState } from 'vuex'
export default {
  components: {
    VTable,
    Pagination,
    ModalEdit,
    ModalAdd
  },
  mixins: [ManageTable, getStatusClassName, filterName, getOptionName],
  props: {
    title: {
      type: String,
      default: '学生列表'
    }
  },
  data: () => ({
    columns: [
      {
        prop: 'name',
        label: '名称',
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
    beforeSubmit(data) {
      data = this.beforeAddSubmit(data)
      data.group_id = this.$route.params.id
      return data
    }
  }
}
</script>
