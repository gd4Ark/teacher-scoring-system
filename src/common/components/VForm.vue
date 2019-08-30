<template>
  <el-form v-if="loaded"
           ref="form"
           :model="formData"
           :show-message="showMessage"
           :inline="inline"
           :rules="rules"
           :label-width="showLabel ? labelWidth : '0'"
           autocomplete="off"
           @submit.native.prevent>
    <v-form-item v-for="(item) in formItem"
                 :key="item.key"
                 :item="item"
                 :form-item="formItem"
                 :form-data="formData"
                 :rules="rules"
                 :splice-key="item.key"
                 @submit="submit" />
    <slot />
  </el-form>
</template>
<script>
import VFormItem from './VFormItem'
import { warning } from '@/common/utils/message'
export default {
  name: 'VForm',
  components: {
    VFormItem
  },
  props: {
    formData: {
      type: Object,
      required: true
    },
    formItem: {
      type: Array,
      required: true
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
    inline: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    rules: {},
    loaded: false
  }),
  mounted() {
    this.initRules(this.formItem)
    this.loaded = true
  },
  methods: {
    submit() {
      let res = false
      this.$refs.form.validate(valid => {
        if (valid) {
          res = true
          return this.$emit('submit')
        }
        warning('请填写正确！')
      })
      return res
    },
    reset() {
      this.$refs.form.resetFields()
      return this.formData
    },
    initRules(formItem, key = '') {
      formItem.forEach((el, index) => {
        const append = el.key ? `.${el.key}` : `[${index}]`
        const k = key ? key + append : el.key
        if (el.rules) {
          this.rules[k] = el.rules
        } else if (el.isObject) {
          this.initRules(el.subs, k)
        } else if (el.isArray) {
          this.initRules(el.subs, k)
        } else if (el.items) {
          this.initRules(el.items, key)
        }
      })
    }
  }
}
</script>
