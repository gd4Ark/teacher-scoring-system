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
                 :before-submit="beforeSubmit"
                 @get-data="getData" />
      <el-button size="small"
                 type="danger"
                 @click="handleDelete(multipleSelection)">删除</el-button>
    </div>

    <v-table :data="stateData.data"
             :columns="columns"
             @selection-change="handleSelectionChange"
             @sort-change="handleSortChange">
      <template slot="columns-after">
        <el-table-column label="教师姓名"
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
            <modal-edit :title=" `编辑科目 ${getSubjectName(scope.row.subject_id)} 中`"
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
import ModalEdit from "@/common/components/ModalEdit";
import ModalAdd from "@/common/components/ModalAdd";
import ManageTable from "@/common/mixins/ManageTable";
import { mapActions, mapState, mapMutations } from "vuex";
export default {
  mixins: [ManageTable],
  components: {
    vTable,
    Pagination,
    ModalEdit,
    ModalAdd
  },
  data: () => ({
    module: __module,
    load: false,
    columns: []
  }),
  async created() {
    await this.getData();
    await this.getOptions("teacher");
    await this.getOptions("subject");
    setTimeout(() => {
      this.load = true;
    }, 0);
  },
  methods: {
    ...mapActions(["getOptions"]),
    ...mapMutations({
      setOrder: __module
    }),
    beforeSubmit(data) {
      data.group_id = this.stateData.group_id;
      return data;
    },
    getTeacherName(id) {
      const item = this.teacher.options.find(el => el.value === id);
      return item ? item.label : "";
    },
    getSubjectName(id) {
      const item = this.subject.options.find(el => el.value === id);
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
