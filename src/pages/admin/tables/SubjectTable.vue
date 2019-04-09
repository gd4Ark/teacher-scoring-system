<template>
  <v-card v-if="load"
          class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
      <modal-add title="添加科目"
                 :form-item="$v_data[module].add.item"
                 :get-form-data="$v_data[module].add.data"
                 :module="module"
                 :before-submit="splitNameList"
                 :success-message="successMessage"
                 @get-data="getData" />
      <el-button size="small"
                 type="danger"
                 @click="handleDelete(multipleSelection)">删除</el-button>
    </div>

    <v-table :data="stateData.data"
             :columns="columns"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <el-table-column slot="columns-after"
                       label="操作"
                       align="center">
        <template slot-scope="scope">
          <modal-edit :title="`编辑科目 ${scope.row.name } 中`"
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
    </v-table>

    <pagination :module="stateData"
                @get-data="getData" />
  </v-card>
</template>
<script>
const __module = "subject";
import vTable from "@/common/components/Table";
import Pagination from "@/common/components/Pagination";
import ModalEdit from "@/common/components/ModalEdit";
import ModalAdd from "@/common/components/ModalAdd";
import ManageTable from "@/common/mixins/ManageTable";
import splitNameList from "@/common/mixins/splitNameList";
import successMessage from "@/common/mixins/successMessage";
import { mapActions, mapState, mapMutations } from "vuex";
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
      default: "科目表"
    }
  },
  data: () => ({
    module: __module,
    load: false,
    columns: [
      {
        prop: "id",
        label: "编号",
        sortable: "custom"
      },
      {
        prop: "name",
        label: "科目名称",
        sortable: "custom"
      }
    ]
  }),
  async created() {
    await this.getData();
    setTimeout(() => {
      this.load = true;
    }, 0);
  },
  methods: {
    ...mapMutations({
      setOrder: __module
    })
  },
  computed: {
    ...mapState({
      stateData: __module
    })
  }
};
</script>