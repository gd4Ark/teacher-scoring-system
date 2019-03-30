<template>
  <v-card class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
      <el-button size="small"
                 type="primary"
                 @click="toAdd">添加</el-button>
      <el-button size="small"
                 type="primary"
                 @click="toAdd">全部允许评分</el-button>
      <el-button size="small"
                 type="danger"
                 @click="toAdd">全部禁止评分</el-button>
      <el-button size="small"
                 type="danger"
                 @click="handleDelete(multipleSelection)">删除</el-button>
    </div>

    <v-table :data="stateData.data"
             :columns="columns"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <template slot="columns-after">
        <el-table-column label="切换评分状态"
                         align="center">
          <template slot-scope="scope">
            <span :class="['status',scope.row.allow ? 'yes' : 'no']"></span>
          </template>
        </el-table-column>
        <el-table-column label="操作"
                         width="330"
                         align="center">
          <template slot-scope="scope">
            <el-button size="mini"
                       @click="toStudent(scope.row.id)">学生管理</el-button>
            <el-button size="mini"
                       @click="toCourse(scope.row.id)">课程管理</el-button>
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
const __module = "group";
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
      default: "班级表"
    }
  },
  data: () => ({
    module: __module,
    columns: [
      {
        prop: "name",
        label: "班级名称",
        sortable: "custom"
      },
      {
        prop: "student_count",
        label: "人数"
      },
      {
        prop: "complete_count",
        label: "已评人数"
      }
    ]
  }),
  created() {
    this.getData();
  },
  methods: {
    ...mapMutations({
      setOrder: __module
    }),
    toAdd() {
      this.$router.push({
        name: "addGroup"
      });
    },
    toStudent(id) {
      this.$router.push({
        name: "student",
        params: {
          id
        }
      });
    },
    toCourse(id) {
      this.$router.push({
        name: "course",
        params: {
          id
        }
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