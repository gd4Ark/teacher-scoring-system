<template >
  <v-card v-if="load"
          class="table-card"
          :title="title">

    <v-table :loading="!load"
             :data="state.data"
             :columns="columns"
             :need-selection="false"
             @sort-change="handleSortChange">
      <template slot="prepend">
        <el-table-column type="expand">
          <template slot-scope="props">
            <div class="suggest">
              <p>建议：</p>
              <pre>{{ props.row.suggest }}</pre>
            </div>
          </template>
        </el-table-column>
        <el-table-column label="班级名称"
                         prop="group_id"
                         sortable="custom"
                         align="center">
          <template slot-scope="scope">
            <span>{{ getGroupName(scope.row.group_id) }}</span>
          </template>
        </el-table-column>
      </template>
      <template slot="append">
        <el-table-column label="建议字数"
                         prop="suggest_len"
                         sortable="custom"
                         align="center">
          <template slot-scope="scope">
            <span>{{ scope.row.suggest_len }}</span>
          </template>
        </el-table-column>
      </template>
    </v-table>

    <pagination :state="state"
                :module="module"
                @get-data="getData" />
  </v-card>
</template>
<script>
const __module = 'scoresDetail'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import splitNameList from '@/common/mixins/splitNameList'
import successMessage from '@/common/mixins/successMessage'
import { mapActions, mapState, mapMutations } from 'vuex'
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
    columns: [
      {
        prop: '教学效果',
        label: '教学效果',
        sortable: 'custom'
      },
      {
        prop: '教学水平',
        label: '教学水平',
        sortable: 'custom'
      },
      {
        prop: '教学能力',
        label: '教学能力',
        sortable: 'custom'
      },
      {
        prop: 'total',
        label: '总分',
        sortable: 'custom'
      }
    ]
  }),
  async created() {
    await this.getData()
    await this.getOptions('groups')
    this.loaded()
  },
  methods: {
    ...mapActions(['getOptions']),
    ...mapMutations(__module, {
      setOrder: 'update'
    }),
    getGroupName(id) {
      const item = this.groups.options.find(el => el.value === id)
      return item ? item.label : ''
    }
  },
  computed: {
    ...mapState({
      state: __module
    }),
    ...mapState(['groups', 'students']),
    title() {
      return (
        `${this.state.teacher.name}老师 ` +
        '所教' +
        `《${this.state.subject.name}》` +
        ' 分数明细表'
      )
    }
  }
}
</script>
<style lang="scss" scoped>
.suggest {
  @include padding;
  pre {
    margin: 1rem 0;
    @include padding;
    text-indent: 2rem;
    border: 1px solid #eee;
  }
}
</style>
