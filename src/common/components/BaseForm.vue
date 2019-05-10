<template>
    <c-form v-if="loaded"
            ref="form"
            :form-item="formItem"
            :form-data="sformData"
            :show-label="showLabel"
            @submit="handleSubmit">
        <el-form-item>
            <slot />
            <el-button v-if="useBtn"
                       :size="btnSize || respBtnSize"
                       :style="btnStyle"
                       :disabled="btnDisabled"
                       type="primary"
                       @click="submit">
                {{
                btnText
                }}
            </el-button>
        </el-form-item>
    </c-form>
</template>
<script>
import cForm from '@/common/components/Form'
import { clone, retainKeys } from '@/common/utils'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
    name: 'BaseForm',
    components: {
        cForm
    },
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
        showLabel: {
            type: Boolean,
            default: true
        },
        useBtn: {
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
        btnText: {
            type: String,
            default: '提交'
        },
        btnStyle: {
            type: Object,
            default: Object
        }
    },
    data: () => ({
        sformData: null
    }),
    computed: {
        loaded() {
            return this.sformData !== null
        }
    },
    mounted() {
        this.reset()
    },
    methods: {
        reset() {
            this.sformData = this.formData
                ? clone(this.formData)
                : this.getFormData()
        },
        submit() {
            this.$refs.form.submit()
        },
        handleSubmit() {
            const data = retainKeys(this.sformData, this.getKeys(this.formItem))
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
