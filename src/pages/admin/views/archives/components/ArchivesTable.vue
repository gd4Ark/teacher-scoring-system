<template>
  <v-card :title="title"
          class="table-card">
    <div slot="toolbar"
         class="toolbar">
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
        <el-table-column label="操作"
                         min-width="130"
                         align="center">
          <template slot-scope="scope">
            <modal-edit :title=" `编辑归档 ${scope.row.name} 中`"
                        :form-item="$v_data[module].common.item"
                        :current="scope.row"
                        :module="module"
                        btn-size="mini"
                        @get-data="getData" />
            <el-button size="mini"
                       @click="toArchivesDetail(scope.row.id)">
              查看明细
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
const allOptions = []
import VTable from '@/common/components/VTable'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ManageTable from '@/common/mixins/ManageTable'
import getOptionName from '@/common/mixins/getOptionName'
import { mapState } from 'vuex'
export default {
  components: {
    VTable,
    Pagination,
    ModalEdit
  },
  mixins: [ManageTable, getOptionName],
  props: {
    title: {
      type: String,
      default: '归档列表'
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
        prop: 'created_at',
        label: '创建时间',
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
    toArchivesDetail(id) {
      this.$router.push({
        name: 'archivesDetail',
        params: {
          id
        }
      })
    }
  }
}
</script>
