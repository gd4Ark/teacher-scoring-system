<template>
    <div class="modal"
         style="display:inline;">
        <div style="display:inline;"
             @click="visible()">
            <slot name="btn">
                <el-button :size="btnSize"
                           :type="btnType"
                           :icon="btnIcon"
                           :style="btnStyle"
                           class="btn">
                    {{ btnText }}
                </el-button>
            </slot>
        </div>
        <el-dialog v-el-drag-dialog
                   :title="title"
                   :visible.sync="dialogVisible"
                   width="95%"
                   @open="open"
                   @close="close">
            <slot name="body" />

            <span slot="footer"
                  class="dialog-footer">
                <slot name="footer">
                    <el-button :size="respBtnSize"
                               @click="hidden">取消</el-button>
                    <el-button :disabled="btnDisabled"
                               :size="respBtnSize"
                               type="primary"
                               @click="submit">提交</el-button>
                </slot>
            </span>
        </el-dialog>
    </div>
</template>
<script>
import elDragDialog from '@/common/directive/el-drag-dialog' // base on element-ui
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
    name: 'Modal',
    directives: { elDragDialog },
    mixins: [ResponsiveSize],
    props: {
        title: {
            type: String,
            default: '弹窗'
        },
        btnDisabled: {
            type: Boolean,
            default: false
        },
        btnText: {
            type: String,
            default: '打开弹框'
        },
        btnSize: {
            type: String,
            default: 'small'
        },
        btnType: {
            type: String,
            default: ''
        },
        btnIcon: {
            type: String,
            default: ''
        },
        btnStyle: {
            type: Object,
            default: () => {
                return {}
            }
        },
        beforeOpen: {
            type: Function,
            default: () => true
        }
    },
    data: () => ({
        dialogVisible: false
    }),
    methods: {
        visible() {
            if (!this.beforeOpen()) {
                return
            }
            this.dialogVisible = true
        },
        hidden() {
            this.dialogVisible = false
        },
        open() {
            this.$emit('open')
        },
        close() {
            this.$emit('close')
        },
        submit() {
            this.$emit('submit')
        }
    }
}
</script>
<style lang="scss" scoped>
.btn {
    margin-left: 10px;
}
</style>
