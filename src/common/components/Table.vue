<template>
  <el-table :data="data"
            style="width: 100%;"
            @selection-change="handleSelectionChange">
    <slot name="columns-before" />
    <el-table-column type="selection" width="40"></el-table-column>
    <el-table-column v-for="(column,index) in columns"
                     :key="index"
                     v-bind="column"
                     align="center">
      <template slot-scope="scope">
        <p v-show="!column.isEdit">{{ scope.row[column.prop] }}</p>
        <p v-show="column.isEdit">
          <form-item :item="column"
                     :model.sync="scope.row[column.prop]" />
        </p>
      </template>
    </el-table-column>
    <slot name="columns-after" />
  </el-table>
</template>
<script>
import FormItem from "@/common/components/FormItem";
import ManageTable from "@/common/mixins/ManageTable";
export default {
  components: {
    FormItem
  },
  mixins: [ManageTable],
  props: {
    data: Array,
    columns: Array
  }
};
</script>
