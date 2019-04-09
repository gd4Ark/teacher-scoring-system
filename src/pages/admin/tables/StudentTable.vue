<template v-if="load">
  <v-card class="table-card"
          :title="title">
    <div class="toolbar"
         slot="toolbar">
      <modal-add title="添加学生"
                 :form-item="$v_data[module].add.item"
                 :get-form-data="$v_data[module].add.data"
                 :module="module"
                 :before-submit="_splitNameList"
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
      <template slot="columns-after">
        <el-table-column label="是否已评"
                         align="center">
          <template slot-scope="scope">
            <span :class="['status',scope.row.complete ? 'yes' : 'no']"></span>
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
const __module = "student";
import vTable from "@/common/components/Table";
import Pagination from "@/common/components/Pagination";
import ModalEdit from "@/common/components/ModalEdit";
import ModalAdd from "@/common/components/ModalAdd";
import ManageTable from "@/common/mixins/ManageTable";
import splitNameList from "@/common/mixins/splitNameList";
import successMessage from "@/common/mixins/successMessage";
import { mapActions, mapState, mapMutations } from "vuex";
import { setTimeout } from "timers";
export default {
  mixins: [ManageTable, splitNameList, successMessage],
  components: {
    vTable,
    Pagination,
    ModalEdit,
    ModalAdd
  },
  data: () => ({
    module: __module,
    load: false,
    columns: [
      {
        prop: "name",
        label: "名字",
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
    _splitNameList(data) {
      const nameList = this.splitNameList(data);
      nameList.forEach(el => {
        el.group_id = this.$route.params.group_id;
      });
      return nameList;
    }
  },
  computed: {
    ...mapState({
      stateData: __module
    }),
    title() {
      const group = this.stateData.group;
      const name = group ? group.name : '';
      return `${name} 学生表`;
    }
  }
};
</script>
