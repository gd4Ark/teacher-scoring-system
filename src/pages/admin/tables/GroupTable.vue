<template>
  <div class="container">
    <search module="group"
            @get-data="getData" />
    <v-card :title="title">
      <div class="toolbar"
           slot="toolbar">
        <el-button size="small"
                   type="primary"
                   @click="add">添加班级</el-button>
        <el-button size="small"
                   type="primary"
                   @click="add">全部允许评分</el-button>
        <el-button size="small"
                   type="danger"
                   @click="add">全部禁止评分</el-button>
        <el-button size="small"
                   type="danger"
                   @click="handleDelete(multipleSelection)">删除</el-button>
      </div>

      <v-table :data="group.list"
               :columns="columns">
        <template slot="columns-after">
          <el-table-column label="切换评分状态"
                           align="center">
            <template slot-scope="scope">
              <span :class="['allow-status',scope.row.allow ? 'yes' : 'no']">{{ scope.row.allow ? '√' : '×' }}</span>
            </template>
          </el-table-column>
          <el-table-column label="操作"
                           width="330"
                           align="center">
            <template slot-scope="scope">
              <el-button size="mini"
                         @click="handleDelete([scope.row.id])">添加学生</el-button>
              <el-button size="mini"
                         @click="handleDelete([scope.row.id])">编辑</el-button>
              <el-button size="mini"
                         type="danger"
                         @click="handleDelete([scope.row.id])">删除</el-button>
            </template>
          </el-table-column>
        </template>
      </v-table>

      <pagination :module="group"
                  @get-data="getData" />
    </v-card>
  </div>
</template>
<script>
import Search from "@/common/components/Search";
import vTable from "@/common/components/Table";
import Pagination from "@/common/components/Pagination";
import ManageTable from "@/common/mixins/ManageTable";
import { mapActions, mapState } from "vuex";
export default {
  mixins: [ManageTable],
  components: {
    vTable,
    Pagination,
    Search
  },
  props: {
    title: {
      type: String,
      default: "班级列表"
    }
  },
  data: () => ({
    columns: [
      {
        prop: "id",
        label: "编号"
      },
      {
        prop: "name",
        label: "班级名称"
      },
      {
        prop: "count",
        label: "人数"
      },
      {
        prop: "complete_count",
        label: "完成人数"
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
      this.$router.push("/group/add");
    }
  },
  computed: {
    ...mapState(["group"])
  }
};
</script>
<style lang="scss" scoped>
.allow-status {
  cursor: pointer;
  font-size: 1.2rem;
  font-weight: bold;
  &.yes {
    color: #67c23a;
  }
  &.no {
    color: #f56c6c;
  }
}
</style>
