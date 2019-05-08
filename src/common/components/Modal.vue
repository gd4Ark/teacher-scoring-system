<template>
  <div class="modal"
       style="display:inline;">
    <div @click="visible()"
         style="display:inline;">
      <slot name="btn">
        <el-button class="btn"
                   :size="btnSize"
                   :type="btnType"
                   :icon="btnIcon"
                   :style="btnStyle">
          {{btnText}}
        </el-button>
      </slot>
    </div>
    <el-dialog :title="title"
               :visible.sync="dialogVisible"
               @open="open"
               @close="close"
               width="95%"
               v-el-drag-dialog>

      <slot name="body">

      </slot>

      <span slot="footer"
            class="dialog-footer">
        <slot name="footer">
          <el-button @click="hidden"
                     :size="respBtnSize">取消</el-button>
          <el-button type="primary"
                     :disabled="btnDisabled"
                     @click="submit"
                     :size="respBtnSize">提交</el-button>
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
  mixins: [ResponsiveSize],
  directives: { elDragDialog },
  data: () => ({
    dialogVisible: false
  }),
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
