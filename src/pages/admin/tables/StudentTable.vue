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

    <v-table :data="stateData.list"
             :columns="columns">
      <template slot="columns-after">
        <el-table-column label="是否已评"
                         align="center">
          <template slot-scope="scope">
            <span :class="['display-status',scope.row.status ? 'yes' : 'no']"></span>
          </template>
        </el-table-column>
        <el-table-column label="操作"
                         align="center">
          <template slot-scope="scope">
            <el-button size="mini"
                       @click="handleDelete([scope.row.id])">编辑</el-button>
            <el-button size="mini"
                       type="danger"
                       @click="handleDelete([scope.row.id])">删除</el-button>
          </template>
        </el-table-column>
      </template>
    </v-table>

    <pagination :module="stateData"
                @get-data="getData" />
  </v-card>
</template>
<script>
const __module = "subject";
import vTable from "@/common/components/Table";
import Pagination from "@/common/components/Pagination";
import ManageTable from "@/common/mixins/ManageTable";
import { mapActions, mapState, mapMutations } from "vuex";
export default {
  mixins: [ManageTable],
  components: {
    vTable,
    Pagination
  },
  props: {
    title: {
      type: String,
      default: "16春计网专（1）班学生表"
    }
  },
  data: () => ({
    module: __module,
    columns: [
      {
        prop: "name",
        label: "名字"
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
    ...mapMutations({
      setOrder: __module
    }),
    add() {
      this.$router.push({
        name: "addStudent"
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
