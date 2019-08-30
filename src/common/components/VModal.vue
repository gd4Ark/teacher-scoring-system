<template>
  <div class="modal"
       style="display:inline;">
    <slot name="custom-open-area"
          :visible="visible"></slot>
    <div style="display:inline;"
         @click="visible">
      <slot v-if="needOpenBtn"
            name="btn">
        <el-button :size="btnSize"
                   :type="btnType"
                   :icon="btnIcon"
                   :style="btnStyle"
                   :disabled="disabled"
                   class="btn">
          {{ openBtnText }}
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

      <span v-if="needFooter"
            slot="footer"
            class="dialog-footer">
        <slot name="footer">
          <slot name="footer-prepend"></slot>
          <el-button :size="respBtnSize"
                     @click="hidden">{{ cancelBtnText }}</el-button>
          <slot name="footer-middle"></slot>
          <el-button :disabled="btnDisabled"
                     :size="respBtnSize"
                     type="primary"
                     @click="submit">{{ submitBtnText }}</el-button>
          <slot name="footer-prepend"></slot>
        </slot>
      </span>
    </el-dialog>
  </div>
</template>
<script>
import elDragDialog from '@/common/directive/el-drag-dialog'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
  name: 'VModal',
  directives: { elDragDialog },
  mixins: [ResponsiveSize],
  props: {
    title: {
      type: String,
      default: '弹窗'
    },
    disabled: {
      type: Boolean,
      default: false
    },
    needDrag: {
      type: Boolean,
      default: true
    },
    needOpenBtn: {
      type: Boolean,
      default: true
    },
    needFooter: {
      type: Boolean,
      default: true
    },
    btnDisabled: {
      type: Boolean,
      default: false
    },
    openBtnText: {
      type: String,
      default: '打开弹框'
    },
    submitBtnText: {
      type: String,
      default: '提交'
    },
    cancelBtnText: {
      type: String,
      default: '取消'
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
      if (!this.beforeOpen()) return
      if (this.disabled) return
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
