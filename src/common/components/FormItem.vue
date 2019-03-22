<template>
  <div v-if="load">
    <!-- 选择 -->
    <el-select v-if="item.type === 'select'"
               v-model="val"
               :size="item.size || ''"
               :placeholder="getPlaceholder(item,'选择')"
               :clearable="true">
      <el-option v-for="option in item.options"
                 :key="option.value"
                 :label="option.label"
                 :value="option.value">
      </el-option>
    </el-select>
    <!-- 日期 -->
    <el-date-picker v-else-if="item.type === 'date'"
                    v-model="val"
                    type="date"
                    :editable="false"
                    :placeholder="getPlaceholder(item,'选择')"
                    value-format="yyyy-MM-dd"
                    clearable>
    </el-date-picker>
    <!-- 滑块 -->
    <el-slider v-else-if="item.type === 'range'"
               v-model="val"
               :step="item.step"
               :min="item.min"
               :max="item.max"
               show-input
               input-size="mini">
    </el-slider>
    <!-- 计数 -->
    <el-input-number v-else-if="item.type === 'inputNumber'"
                     v-model="val"
                     :step="item.step"
                     :min="item.min"
                     :max="item.max">
    </el-input-number>
    <!-- 上传 -->
    <template v-else-if="item.type === 'file'">
      <upload :item="item"
              :model.sync="val" />
    </template>
    <!-- 开关 -->
    <el-switch v-else-if="item.type === 'switch'"
               v-model="val"
               active-color="#13ce66"
               inactive-color="#ff4949"
               inactive-value="0"
               active-value="1" />
    <!-- 默认 -->
    <el-input v-else
              :type="item.type"
              :placeholder="getPlaceholder(item)"
              :rows="item.row"
              :min="item.min"
              :max="item.max"
              v-model="val" />
  </div>
</template>
<script>
import Upload from "./Upload";
export default {
  components: {
    Upload
  },
  props: {
    item: Object,
    model: [String, Number, Boolean, File]
  },
  data: () => ({
    load: false,
    val: ""
  }),
  mounted() {
    this.val = this.model;
    this.load = true;
  },
  methods: {
    getPlaceholder(item, type = "输入") {
      return item.placeholder || `请${type}` + item.label;
    }
  },
  watch: {
    val(val) {
      this.$emit("update:model", val);
    },
    model(val) {
      if (this.val !== val) {
        this.val = val;
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.el-form-item__content div {
  display: block;
}
.el-form-item {
  margin-bottom: 12px;
}
</style>