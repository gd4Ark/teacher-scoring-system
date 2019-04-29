<template>
  <el-table :data="data"
            v-loading="loading"
            height="90%"
            style="width: 100%;"
            @selection-change="handleSelectionChange"
            @sort-change="handleSortChange">
    <slot name="prepend" />
    <el-table-column type="selection"></el-table-column>
    <el-table-column v-for="(column,index) in columns"
                     :key="index"
                     v-bind="column"
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
  name: 'Table',
  props: {
    data: Array,
    columns: Array,
    loading: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    handleSelectionChange(val) {
      this.$emit('selection-change', val)
    },
    handleSortChange(val) {
      this.$emit('sort-change', val)
    }
  }
}
</script>
<style lang="scss">
.table {
  width: 100%;
  margin: 2% auto;
  border-radius: 5px;
}

.el-table {
  font-size: 0.95rem;
}
.el-table .warning-row {
  background: oldlace;
}

.el-table__body-wrapper {
  @include no-scrollbar;
}
</style>
