<template>
  <div class="modal"
       style="display:inline;">
    <div @click="visible()"
         style="display:inline;">
      <slot name="btn">
        <el-button :size="btnSize"
                   :type="btnType">{{btnText}}</el-button>
      </slot>
    </div>
    <el-dialog :title="title"
               :visible.sync="dialogVisible"
               @open="open"
               @close="close"
               width="90%">

      <slot name="body">

      </slot>

      <span slot="footer"
            class="dialog-footer">
        <slot name="footer">
          <el-button @click="hidden">取 消</el-button>
          <el-button type="primary"
                     @click="submit">确 定</el-button>
        </slot>
      </span>
    </el-dialog>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dialogVisible: false
    };
  },
  props: {
    title: {
      type: String,
      default: "弹窗"
    },
    btnText: {
      type: String,
      default: "打开弹框"
    },
    btnSize: {
      type: String,
      default: "small"
    },
    btnType: {
      type: String,
      default: ""
    },
    beforeOpen: {
      type: Function,
      default: () => true
    }
  },
  methods: {
    visible() {
      if (!this.beforeOpen()) {
        return;
      }
      this.dialogVisible = true;
    },
    hidden() {
      this.dialogVisible = false;
    },
    open() {
      this.$emit("open");
    },
    close() {
      this.$emit("close");
    },
    submit() {
      this.$emit("submit");
    }
  }
};
</script>