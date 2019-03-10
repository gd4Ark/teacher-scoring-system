<template>
  <el-form v-if="formData"
           :inline="inline"
           ref="form"
           :label-width="showLabel ? '70px' : 0"
           autocomplete="off">

    <el-form-item v-for="(item,index) in formItem"
                  :key="index"
                  :label="item.label">

      <!-- 一行多个 -->
      <template v-if="item.items">
        <template v-for="(it,index) in item.items">
          <el-col v-if="index>0"
                  :key="index"
                  class="line"
                  :span="2">-</el-col>
          <el-col :span="11"
                  :key="index">
            <form-item :item="item"
                       :key="index"
                       :model.sync="formData[item.key][index]" />
          </el-col>
        </template>
      </template>

      <!-- 一行一个 -->
      <template v-else>
        <form-item :item="item"
                   :model.sync="formData[item.key]" />
      </template>

    </el-form-item>

    <slot></slot>

  </el-form>
</template>
<script>
import FormItem from "@/common/components/FormItem";
export default {
  components: {
    FormItem
  },
  props: {
    formData: Object,
    formItem: Array,
    showLabel: {
      type: Boolean,
      default: true
    },
    inline: {
      type: Boolean,
      default: false
    }
  }
};
</script>
<style lang="scss" scoped>
.line {
  display: block;
  text-align: center;
}
</style>