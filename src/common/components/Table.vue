<template>
  <el-table :data="data"
            height="90%"
            style="width: 100%;"
            @selection-change="handleSelectionChange"
            @sort-change="handleSortChange">
    <slot name="columns-before" />
    <el-table-column type="selection"></el-table-column>
    <el-table-column v-for="(column,index) in columns"
                     :key="index"
                     v-bind="column"
                     align="center">
      <template slot-scope="scope">
        <p>{{ scope.row[column.prop] }}</p>
      </template>
    </el-table-column>
    <slot name="columns-after" />
  </el-table>
</template>
<script>
export default {
  props: {
    data: Array,
    columns: Array
  },
  methods: {
    handleSelectionChange(val) {
      this.$emit("selection-change", val);
    },
    handleSortChange(val) {
      this.$emit("sort-change", val);
    }
  }
};
</script>
