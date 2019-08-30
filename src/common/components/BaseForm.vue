<template>
  <v-form v-if="loaded"
          ref="form"
          :inline="inline"
          :form-item="formItem"
          :form-data="newFormData"
          :show-label="showLabel"
          :label-width="labelWidth"
          :show-message="showMessage"
          @submit="handleSubmit">
    <el-form-item>
      <slot name="prepend" />
      <el-button v-if="needSubmitBtn"
                 :size="btnSize || respBtnSize"
                 :style="btnStyle"
                 :disabled="btnDisabled"
                 type="primary"
                 @click="submit">
        {{
        submitBtnText
        }}
      </el-button>
      <el-button v-if="needResetBtn"
                 :size="btnSize || respBtnSize"
                 @click="resetForm">
        {{
        resetBtnText
        }}
      </el-button>
      <slot name="append" />
    </el-form-item>
  </v-form>
</template>
<script>
import { retainKeys } from '@/common/utils'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
  name: 'BaseForm',
  mixins: [ResponsiveSize],
  props: {
    formItem: {
      type: Array,
      required: true
    },
    formData: {
      type: Object,
      default: null
    },
    getFormData: {
      type: Function,
      default: () => {}
    },
    inline: {
      type: Boolean,
      default: false
    },
    showLabel: {
      type: Boolean,
      default: true
    },
    labelWidth: {
      type: String,
      default: '85px'
    },
    showMessage: {
      type: Boolean,
      default: true
    },
    needSubmitBtn: {
      type: Boolean,
      default: true
    },
    needResetBtn: {
      type: Boolean,
      default: true
    },
    btnDisabled: {
      type: Boolean,
      default: false
    },
    btnSize: {
      type: String,
      default: ''
    },
    submitBtnText: {
      type: String,
      default: '提交'
    },
    resetBtnText: {
      type: String,
      default: '重置'
    },
    btnStyle: {
      type: Object,
      default: Object
    }
  },
  data: () => ({
    newFormData: null
  }),
  computed: {
    loaded() {
      return this.newFormData !== null
    }
  },
  mounted() {
    this.reset()
  },
  methods: {
    reset() {
      this.newFormData = this.formData
        ? this._.clone(this.formData)
        : this.getFormData()
      this.resetForm()
    },
    resetForm() {
      this.$nextTick(() => {
        const formData = this.$refs.form.reset()
        this.$emit('reset', formData)
      })
    },
    submit() {
      return this.$refs.form.submit()
    },
    handleSubmit() {
      const data = retainKeys(this.newFormData, this.getKeys(this.formItem))
      this.$emit('submit', data)
    },
    getKeys(array) {
      let keys = []
      array.forEach(item => {
        if (item.items) {
          keys = keys.concat(this.getKeys(item.items))
          return
        }
        keys.push(item.key)
      })
      return keys
    }
  }
}
</script>
