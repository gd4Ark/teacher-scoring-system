<template>
  <v-card :title="title"
          class="table-card">
    <div slot="toolbar"
         class="toolbar">
    </div>

    <v-table ref="table"
             :highlight-current-row="!multiple"
             :loading="loading"
             :data="state.data"
             :columns="columns"
             :need-selection="multiple"
             @sort-change="handleSortChange"
             @current-change="currentChange"
             @selection-change="handleSelectionChange">
    </v-table>

    <pagination :state="state"
                :module="module"
                :get-data="getData"
                @before-change="beforeChange"
                @after-change="afterChange" />
  </v-card>
</template>
<script>
import VTable from '@/common/components/VTable'
import Pagination from '@/common/components/Pagination'
import simpleTable from '@/common/mixins/simpleTable'
export default {
  components: {
    VTable,
    Pagination
  },
  mixins: [simpleTable],
  props: {
    title: {
      type: String,
      default: '列表'
    },
    multiple: {
      type: Boolean,
      default: false
    },
    tableColumns: {
      type: Array,
      default: () => []
    }
  },
  data: () => ({
    default_columns: [
      {
        prop: 'id',
        label: '编号',
        sortable: 'custom',
        minWidth: 100
      },
      {
        prop: 'name',
        label: '名称',
        sortable: 'custom'
      }
    ]
  }),
  computed: {
    columns() {
      return this.tableColumns.length === 0
        ? this.default_columns
        : this.tableColumns
    }
  },
  async created() {
    await Promise.all([this.getData()])
    this.loaded = true
    this.makeLoaded()
  },
  methods: {
    currentChange(...data) {
      if (this.multiple) return
      this.$emit('current-change', ...data)
    }
  }
}
</script>
