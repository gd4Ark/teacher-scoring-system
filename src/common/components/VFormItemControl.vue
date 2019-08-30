<template>
  <div v-if="loaded">
    <!-- select -->
    <el-select v-if="item.type === 'select'"
               v-model="val"
               :multiple="_.get(item,'meta.multiple')"
               :multiple-limit="_.get(item,'meta.multiple_limit',0)"
               :size="respFormControlSize"
               :filterable="_.get(item,'meta.filterable')"
               :placeholder="getPlaceholder('选择')"
               :clearable="_.get(item,'meta.clearable',true)"
               @change="changeSelect">
      <el-option v-for="option in getOptions()"
                 :key="option.value"
                 :label="option.label"
                 :value="option.value" />
      <template v-if="_.get(item,'meta.create_link')"
                slot="empty">
        <div class="create-select">
          <span>该{{ item.label }}不存在</span>
          <router-link :to="item.meta.create_link + '?redirect=' + $route.path">点我创建</router-link>
        </div>
      </template>
    </el-select>
    <!-- radio -->
    <el-radio-group v-else-if="item.type === 'radio'"
                    v-model="val"
                    :size="respFormControlSize"
                    @change="changeSelect">
      <component :is="_.get(item,'meta.radio_type','el-radio')"
                 v-for="option in getOptions()"
                 :key="option.value"
                 :label="option.value">
        {{ option.label }}
      </component>
    </el-radio-group>
    <!-- cascader -->
    <el-cascader v-else-if="item.type === 'cascader'"
                 v-model="val"
                 :options="_.get(item,'meta.options')"
                 :filterable="_.get(item,'meta.filterable')"
                 :placeholder="getPlaceholder('选择')"
                 :props="_.get(item,'meta.props',{})"
                 :show-all-levels="_.get(item,'meta.showAllLevels',true)"
                 :clearable="_.get(item,'meta.clearable',true)"
                 :size="respFormControlSize" />
    <!-- date -->
    <el-date-picker v-else-if="item.type === 'date'"
                    v-model="val"
                    :type="_.get(item,'meta.control_type','date')"
                    :time-arrow-control="true"
                    :align="_.get(item,'meta.align','center')"
                    :editable="_.get(item,'meta.editable',true)"
                    :clearable="_.get(item,'meta.clearable',true)"
                    :value-format="_.get(item,'meta.format','yyyy-MM-dd')"
                    :range-separator="_.get(item,'meta.range_separator','至')"
                    :start-placeholder="_.get(item,'meta.start_placeholder','开始日期')"
                    :end-placeholder="_.get(item,'meta.end_placeholder','结束日期')"
                    :placeholder="getPlaceholder('选择')"
                    :size="respFormControlSize"
                    @change="changeSelect" />
    <!-- sidebar -->
    <el-slider v-else-if="item.type === 'range'"
               v-model="val"
               :step="_.get(item,'meta.step')"
               :min="_.get(item,'meta.min')"
               :max="_.get(item,'meta.max')"
               show-input
               input-size="mini" />
    <!-- count -->
    <el-input-number v-else-if="item.type === 'inputNumber'"
                     v-model="val"
                     :step="_.get(item,'meta.step')"
                     :min="_.get(item,'meta.min')"
                     :max="_.get(item,'meta.max')" />
    <!-- upload -->
    <template v-else-if="item.type === 'file'">
      <upload-control :item="item"
                      :model.sync="val" />
    </template>
    <!-- upload-pic -->
    <template v-else-if="item.type === 'pic'">
      <upload-pic-control :item="item"
                          :model.sync="val" />
    </template>
    <!-- switch -->
    <el-switch v-else-if="item.type === 'switch'"
               v-model="val"
               :inactive-value="getInactive"
               :active-value="getActive"
               active-color="#13ce66"
               inactive-color="#ff4949" />
    <!-- code -->
    <codemirror v-else-if="item.type === 'code'"
                v-model="val"
                :style="item.meta.style"
                :placeholder="getPlaceholder()"
                :options="codemirrorOptions"
                class="codemirror" />
    <!-- location -->
    <location-control v-else-if="item.type === 'location'"
                      :model.sync="val"
                      :size="respFormControlSize"
                      :placeholder="getPlaceholder()" />
    <!-- select table -->
    <select-table v-else-if="item.type === 'select-table'"
                  :model.sync="val"
                  :size="respFormControlSize"
                  :multiple="_.get(item,'meta.multiple')"
                  :module="_.get(item,'meta.module')"
                  :title="_.get(item,'meta.title','列表')"
                  :table-title="_.get(item,'meta.table.title','列表')"
                  :table-columns="_.get(item,'meta.table.columns',[])"
                  :before-submit="_.get(item,'meta.beforeSubmit',data => data)"
                  :placeholder="getPlaceholder()" />
    <!-- rich text -->
    <rich-text v-else-if="item.type === 'richtext'"
               ref="richText"
               v-model=" val" />
    <!-- default -->
    <el-input v-else
              v-model="val"
              :type="item.type"
              :placeholder="getPlaceholder()"
              :clearable="_.get(item,'meta.clearable',true)"
              :rows="_.get(item,'meta.row')"
              :min="_.get(item,'meta.min')"
              :max="_.get(item,'meta.max')"
              :size="respFormControlSize"
              @keyup.enter.native="submit">
      <template v-if="_.get(item,'meta.slot')"
                :slot="item.meta.slot.name">
        <template v-if="item.meta.slot.type === 'icon'">
          <i :class="['icon',item.meta.slot.value]" />
        </template>
        <template v-else>
          {{ item.meta.slot.value }}
        </template>
      </template>
    </el-input>
  </div>
</template>
<script>
import LocationControl from './FormControls/LocationControl'
import UploadControl from './FormControls/UploadControl'
import UploadPicControl from './FormControls/UploadPicControl'
import RichText from './FormControls/Tinymce/'
import SelectTable from './FormControls/SelectTable'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
import { codemirror } from 'vue-codemirror-lite'
import 'codemirror/addon/display/placeholder.js'
import 'codemirror/mode/htmlmixed/htmlmixed'
export default {
  name: 'VFormItemControl',
  components: {
    LocationControl,
    UploadControl,
    UploadPicControl,
    codemirror,
    RichText,
    SelectTable
  },
  mixins: [ResponsiveSize],
  props: {
    item: {
      type: Object,
      required: true
    },
    model: {
      type: [String, Number, Boolean, File, Object, Array],
      required: true
    }
  },
  data: () => ({
    loaded: false,
    val: '',
    options: [],
    codemirrorOptions: {
      mode: 'htmlmixed',
      tabSize: 2,
      lineNumbers: true,
      lineWrapping: false
    }
  }),
  computed: {
    getActive() {
      return this._.get(this.item, 'meta.active', true)
    },
    getInactive() {
      return this._.get(this.item, 'meta.inactive', false)
    }
  },
  watch: {
    val(val) {
      if (this._.isNull(val)) {
        val = ''
      }
      this.$emit('update:model', val)
    },
    model(val) {
      if (!this._.isEqual(this.val, val)) {
        this.resetRichText(val)
        this.setVal(val)
      }
    }
  },
  mounted() {
    this.setVal(this.model)
    this.codemirrorOptions.placeholder = this.getPlaceholder()
    this.loaded = true
  },
  methods: {
    submit() {
      if (this._.get(this.item, 'meta.disabledEvent')) return
      this.$emit('submit')
    },
    resetRichText(val) {
      if (this.$refs.richText) {
        setTimeout(() => {
          this.$refs.richText.setContent(val)
        }, 300)
      }
    },
    setVal(val) {
      if (val === '') {
        this.val = val
        return
      }
      const type = this._.get(this.item, 'meta.type')
      switch (type) {
        case 'number':
          this.val = Number(val)
          break
        default:
          this.val = val
          break
      }
    },
    changeSelect() {
      if (!this._.get(this.item, 'meta.enableEvent', false)) return
      setTimeout(() => {
        this.$emit('submit')
      }, 20)
    },
    getPlaceholder(type = '输入') {
      return (
        this._.get(this.item, 'meta.placeholder') ||
        `请${type}` + this.item.label
      )
    },
    getOptions() {
      if (this._.get(this.item, 'meta.options')) {
        return this.item.meta.options
      }
      const module = this._.get(this.item, 'meta.option_module')
      return this.$store.state[module].options
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
.create-select {
  line-height: 2.5;
  text-align: center;
  a {
    margin-left: 5px;
    color: $color-primary;
  }
}
</style>
<style lang="scss">
.CodeMirror pre.CodeMirror-placeholder {
  color: #c0c4cc;
  font: 400 13.3333px Arial;
}
.CodeMirror {
  padding: 0;
  height: 100%;
}
.CodeMirror pre {
  font-size: 1rem;
}
</style>
