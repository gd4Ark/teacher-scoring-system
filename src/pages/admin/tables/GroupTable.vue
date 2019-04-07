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
                 @click="allToggleAllow(1)">一键允许评分</el-button>
      <el-button size="small"
                 type="danger"
                 @click="allToggleAllow(0)">一键禁止评分</el-button>
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
            <el-switch v-model="scope.row.allow"
                       :active-value="1"
                       :inactive-value="0"
                       active-color="#13ce66"
                       inactive-color="#ff4949"
                       @change="toggleAllow(scope.row)" />
          </template>
        </el-table-column>
        <el-table-column label="操作"
                         width="330"
                         align="center">
          <template slot-scope="scope">
            <el-button size="mini"
                       @click="toStudent(scope.row.id)">学生管理</el-button>
            <el-button size="mini"
                       @click="toTeaching(scope.row.id)">课程管理</el-button>
            <modal-edit :title=" `编辑班级 ${scope.row.name} 中`"
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
import ModalEdit from "@/common/components/ModalEdit";
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
        label: "人数",
        sortable: "custom"
      },
      {
        prop: "complete_count",
        label: "已评人数",
        sortable: "custom"
      }
    ]
  }),
  created() {
    this.getData();
  },
  methods: {
    ...mapActions(["update", "updateBatch"]),
    ...mapMutations({
      setOrder: __module
    }),
    async toggleAllow(row) {
      await this.update({
        module: this.module,
        data: {
          id: row.id,
          allow: row.allow,
        }
      });
      this.getData();
    },
    async allToggleAllow(allow) {
      await this.updateBatch({
        module: this.module,
        all: 1,
        data: {
          allow
        }
      });
      await this.getData();
    },
    toAdd() {
      this.$router.push({
        name: "addGroup"
      });
    },
    toStudent(group_id) {
      this.$router.push({
        name: "student",
        params: {
          group_id
        }
      });
    },
    toTeaching(group) {
      this.$router.push({
        name: "teaching",
        params: {
          group
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