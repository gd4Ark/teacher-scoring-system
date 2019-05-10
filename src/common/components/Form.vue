<template>
    <el-form v-if="loaded"
             ref="form"
             :model="formData"
             :show-message="false"
             :inline="inline"
             :rules="rules"
             :label-width="showLabel ? '80px' : '0'"
             autocomplete="off"
             @submit.native.prevent>
        <form-item v-for="(item) in formItem"
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
import FormItem from '@/common/components/FormItem'
import { warning } from '@/common/utils/message'
export default {
    name: 'Form',
    components: {
        FormItem
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
            this.$refs.form.validate(valid => {
                if (valid) {
                    this.$emit('submit')
                } else {
                    warning('请填写正确！')
                }
            })
        },
        initRules(formItem, key = '') {
            formItem.forEach(el => {
                const k = key ? key + '.' + el.key : el.key
                if (el.rules) {
                    this.rules[k] = el.rules
                } else if (el.isGroup) {
                    this.initRules(el.group, k)
                } else if (el.items) {
                    this.initRules(el.items, key)
                }
            })
        }
    }
}
</script>
