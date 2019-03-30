<template>
  <div v-if="load">
    <!-- 选择 -->
    <el-select v-if="item.type === 'select'"
               v-model="val"
               :size="item.size || ''"
               :placeholder="getPlaceholder('选择')"
               :clearable="true">
      <el-option v-for="option in getOptions()"
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
                    :placeholder="getPlaceholder('选择')"
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
               :inactive-value="getInactive"
               :active-value="getActive" />
    <!-- 默认 -->
    <el-input v-else
              :type="item.type"
              :placeholder="getPlaceholder()"
              :rows="item.row"
              :min="item.min"
              :max="item.max"
              v-model="val"
              @keyup.enter.native="submit" />
  </div>
</template>
<script>
import Upload from "./Upload";
import { setTimeout } from "timers";
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
    val: "",
    options: []
  }),
  mounted() {
    this.val = this.model;
    this.load = true;
  },
  methods: {
    submit() {
      if (this.item.disabledEvent) return;
      this.$emit("submit");
    },
    getPlaceholder(type = "输入") {
      return this.item.placeholder || `请${type}` + this.item.label;
    },
    getOptions() {
      if (this.item.options) return this.item.options;
      const module = this.item.option_module;
      return this.$store.state[module].options;
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
  },
  computed: {
    getActive() {
      return this.item.active !== void 0 ? this.item.active : true;
    },
    getInactive() {
      return this.item.inactive !== void 0 ? this.item.inactive : false;
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