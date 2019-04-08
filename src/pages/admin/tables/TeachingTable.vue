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
      <template slot="columns-after">
        <el-table-column label="教师名称"
                         align="center">
          <template slot-scope="scope">
            <span>{{ getTeacherName(scope.row.teacher_id) }}</span>
          </template>
        </el-table-column>
        <el-table-column label="科目名称"
                         align="center">
          <template slot-scope="scope">
            <span>{{ getSubjectName(scope.row.subject_id) }}</span>
          </template>
        </el-table-column>
        <el-table-column label="操作"
                         align="center">
          <template slot-scope="scope">
            <modal-edit :title=" `编辑学生 ${scope.row.name} 中`"
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
const __module = "teaching";
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
  data: () => ({
    module: __module,
    load: false,
    columns: []
  }),
  async created() {
    await this.getData();
    await this.getOptions("teacher");
    setTimeout(() => {
      this.load = true;
    }, 0);
  },
  methods: {
    ...mapActions(["getOptions"]),
    ...mapMutations({
      setOrder: __module
    }),
    add() {
      this.$router.push({
        name: "addTeaching"
      });
    },
    getTeacherName(id) {
      const item = this.teacher.options.find(el => el.value === id);
      return item ? item.label : "";
    },
    getSubjectName(id) {
      const item = this.teacher.options.find(el => el.value === id);
      return item ? item.label : "";
    }
  },
  computed: {
    ...mapState({
      stateData: __module
    }),
    ...mapState(["teacher", "subject"]),
    title() {
      return `${this.stateData.group.name} 课程表`;
    }
  }
};
</script>
