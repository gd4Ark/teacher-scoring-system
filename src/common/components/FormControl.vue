<template>
  <div v-if="load">
    <!-- select -->
    <el-select v-if="item.type === 'select'"
               v-model="val"
               :size="respFormControlSize"
               :placeholder="getPlaceholder('选择')"
               :clearable="true">
      <el-option v-for="option in getOptions()"
                 :key="option.value"
                 :label="option.label"
                 :value="option.value">
      </el-option>
    </el-select>
    <!-- date -->
    <el-date-picker v-else-if="item.type === 'date'"
                    v-model="val"
                    type="date"
                    :editable="false"
                    :placeholder="getPlaceholder('选择')"
                    value-format="yyyy-MM-dd"
                    clearable>
    </el-date-picker>
    <!-- sidebar -->
    <el-slider v-else-if="item.type === 'range'"
               v-model="val"
               :step="item.step"
               :min="item.min"
               :max="item.max"
               show-input
               input-size="mini">
    </el-slider>
    <!-- count -->
    <el-input-number v-else-if="item.type === 'inputNumber'"
                     v-model="val"
                     :step="item.step"
                     :min="item.min"
                     :max="item.max">
    </el-input-number>
    <!-- upload -->
    <template v-else-if="item.type === 'file'">
      <upload-control :item="item"
                      :model.sync="val" />
    </template>
    <!-- switch -->
    <el-switch v-else-if="item.type === 'switch'"
               v-model="val"
               active-color="#13ce66"
               inactive-color="#ff4949"
               :inactive-value="getInactive"
               :active-value="getActive" />
    <!-- code -->
    <codemirror v-else-if="item.type === 'code'"
                class="codemirror"
                v-model="val"
                :style="item.style"
                :placeholder="getPlaceholder()"
                :options="codemirrorOptions"></codemirror>
    <!-- default -->
    <el-input v-else
              :type="item.type"
              :placeholder="getPlaceholder()"
              :rows="item.row"
              :min="item.min"
              :max="item.max"
              v-model="val"
              :size="respFormControlSize"
              @keyup.enter.native="submit">
      <template v-if="item.slot"
                :slot="item.slot.name">
        <template v-if="item.slot.type === 'icon'">
          <i :class="['icon',item.slot.value]"></i>
        </template>
        <template v-else>
          {{ item.slot.value }}
        </template>
      </template>
    </el-input>
  </div>
</template>
<script>
import UploadControl from './UploadControl'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
import { codemirror } from 'vue-codemirror-lite'
import 'codemirror/addon/display/placeholder.js'
import 'codemirror/mode/htmlmixed/htmlmixed'
export default {
  name: 'FormControl',
  mixins: [ResponsiveSize],
  components: {
    UploadControl,
    codemirror
  },
  props: {
    item: Object,
    model: [String, Number, Boolean, File]
  },
  data: () => ({
    load: false,
    val: '',
    options: [],
    codemirrorOptions: {
      mode: 'htmlmixed',
      tabSize: 2,
      lineNumbers: false,
      lineWrapping: false
    }
  }),
  mounted() {
    this.val = this.model
    this.codemirrorOptions.placeholder = this.getPlaceholder()
    this.load = true
  },
  methods: {
    submit() {
      if (this.item.disabledEvent) return
      this.$emit('submit')
    },
    getPlaceholder(type = '输入') {
      return this.item.placeholder || `请${type}` + this.item.label
    },
    getOptions() {
      if (this.item.options) return this.item.options
      const module = this.item.option_module
      return this.$store.state[module].options
    }
  },
  watch: {
    val(val) {
      this.$emit('update:model', val)
    },
    model(val) {
      if (this.val !== val) {
        this.val = val
      }
    }
  },
  computed: {
    getActive() {
      return this.item.active !== void 0 ? this.item.active : true
    },
    getInactive() {
      return this.item.inactive !== void 0 ? this.item.inactive : false
    }
  }
}
</script>
<style lang="scss" scoped>
.el-form-item__content div:not(.el-input-group) {
  display: block;
}
.el-form-item {
  margin-bottom: 12px;
}
.icon {
  font-size: 1.1rem;
}
.is-error {
  .codemirror {
    border-color: #f56c6c;
  }
}
.codemirror {
  padding: 1px;
  border: 1px solid #dcdfe6;
  border-radius: 4px;
  transition: border-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
  line-height: 17px;
}
</style>
<style lang="scss">
.CodeMirror pre.CodeMirror-placeholder {
  color: #c0c4cc;
  font: 400 13.3333px Arial;
}
.CodeMirror {
  padding: 5px 10px;
  height: 100%;
}
</style>
