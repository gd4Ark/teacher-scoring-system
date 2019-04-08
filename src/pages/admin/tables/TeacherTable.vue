<template>
  <v-card v-if="load"
          class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
      <el-button size="small"
                 type="primary"
                 @click="add">添加</el-button>
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
          <modal-edit :title="`编辑教师 ${scope.row.name } 中`"
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
const __module = "teacher";
import vTable from "@/common/components/Table";
import Pagination from "@/common/components/Pagination";
import ModalEdit from "@/common/components/ModalEdit";
import ManageTable from "@/common/mixins/ManageTable";
import { mapActions, mapState, mapMutations } from "vuex";
export default {
  mixins: [ManageTable],
  components: {
    vTable,
    Pagination,
    ModalEdit
  },
  props: {
    title: {
      type: String,
      default: "教师表"
    }
  },
  data: () => ({
    module: __module,
    load: false,
    columns: [
      {
        prop: "name",
        label: "教师姓名",
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
    }),
    add() {
      this.$router.push({
        name: "addTeacher"
      });
    }
  },
  computed: {
    ...mapState({
      stateData: __module
    })
  }
};
</script>
