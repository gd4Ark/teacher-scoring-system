<template>
  <el-table :data="data"
            v-loading="loading"
            :height="height"
            @selection-change="handleSelectionChange"
            @sort-change="handleSortChange">
    <el-table-column v-if="needSelection"
                     type="selection"
                     align="center"></el-table-column>
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
  name: 'Table',
  props: {
    data: Array,
    columns: Array,
    height: {
      type: String,
      default: '93%'
    },
    loading: {
      type: Boolean,
      default: false
    },
    needSelection: {
      type: Boolean,
      default: true
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
}
.el-table {
  position: relative;
  font-size: $table-font-size;
  width: $table-width;
  // height: $table-height;
  a {
    color: $gighlight-color;
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
