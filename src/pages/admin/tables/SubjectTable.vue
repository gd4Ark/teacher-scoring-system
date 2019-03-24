<template>
  <v-card class="table-card"
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

    <v-table :data="subject.list"
             :columns="columns">
      <el-table-column slot="columns-after"
                       label="操作"
                       align="center">
        <template slot-scope="scope">
          <modal-edit :title="`编辑 ${scope.row.name } 中`"
                      :form-item="$v_data.subject.edit.item"
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

    <pagination :module="subject"
                @get-data="getData" />
  </v-card>
</template>
<script>
import vTable from "@/common/components/Table";
import Pagination from "@/common/components/Pagination";
import ModalEdit from "@/common/components/ModalEdit";
import ManageTable from "@/common/mixins/ManageTable";
import { mapActions, mapState } from "vuex";
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
      default: "科目表"
    }
  },
  data: () => ({
    module: "subject",
    columns: [
      {
        prop: "name",
        label: "科目名称"
      }
    ]
  }),
  created() {
    this.getData();
  },
  methods: {
    ...mapActions({
      delData: "deltemplate"
    }),
    add() {
      this.$router.push({
        name: "addSubject"
      });
    }
  },
  computed: {
    ...mapState(["subject"])
  }
};
</script>
