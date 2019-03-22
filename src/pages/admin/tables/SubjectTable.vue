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
          <el-button size="mini"
                     @click="handleDelete([scope.row.id])">编辑</el-button>
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
import ManageTable from "@/common/mixins/ManageTable";
import { mapActions, mapState } from "vuex";
export default {
  mixins: [ManageTable],
  components: {
    vTable,
    Pagination
  },
  props: {
    title: {
      type: String,
      default: "科目表"
    }
  },
  data: () => ({
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
