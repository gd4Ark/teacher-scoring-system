<template>
  <el-table :key="'table-' + key"
            v-loading="loading"
            :data="data"
            fit
            :highlight-current-row="highlightCurrentRow"
            @selection-change="handleSelectionChange"
            @sort-change="handleSortChange"
            @current-change="handleCurrentChange">
    <el-table-column v-if="needSelection"
                     type="selection"
                     align="center" />
    <slot name="prepend" />
    <el-table-column v-for="(column,index) in columns"
                     :key="index"
                     v-bind="column"
                     :render-header="column.isRender ? renderHeader : null"
                     align="center">
      <template slot-scope="scope">
        <p>{{ scope.row[column.prop] }}</p>
      </template>
    </el-table-column>
    <slot name="append" />
  </el-table>
</template>
<script>
export default {
  name: 'VTable',
  props: {
    data: {
      type: Array,
      required: true
    },
    height: {
      type: String,
      default: '93%'
    },
    columns: {
      type: Array,
      required: true
    },
    loading: {
      type: Boolean,
      default: false
    },
    needSelection: {
      type: Boolean,
      default: true
    },
    highlightCurrentRow: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    key: new Date().getTime()
  }),
  methods: {
    handleSelectionChange(val) {
      this.$emit('selection-change', val)
    },
    handleSortChange(val) {
      this.$emit('sort-change', val)
    },
    handleCurrentChange(...data) {
      this.$emit('current-change', ...data)
    },
    refreshTable() {
      this.key++
    }
  }
}
</script>
<style lang="scss">
.table {
  width: 100%;
}
.el-table {
  position: relative;
  @include flex-column;
  font-size: $table-font-size;
  width: $table-width;
  height: $table-height;
  .el-table__header-wrapper {
    overflow: initial;
  }
  .el-table__body-wrapper {
    flex: 1;
    overflow: auto;
  }
  a {
    color: $color-primary;
  }
}
.el-table td,
.el-table th {
  padding: $table-row-padding;
}
.el-table .warning-row {
  background: oldlace;
}

.el-table__body-wrapper {
  @include no-scrollbar;
  scroll-behavior: smooth;
}
</style>
