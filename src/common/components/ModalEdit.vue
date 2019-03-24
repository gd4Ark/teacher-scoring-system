<template>
  <modal ref="modal"
         :title="title"
         :btn-text="btnText"
         :btn-size="btnSize"
         :btn-type="btnType"
         :before-open="onBeforeOpen"
         @submit="submit"
         @open="reset">
    <baseForm slot="body"
              ref="baseForm"
              :use-btn="false"
              :btn-text="btnText"
              :form-item="formItem"
              :form-data="formData"
              @submit="handleSubmit" />
  </modal>
</template>
<script>
import Modal from "@/common/components/Modal";
import BaseForm from "@/common/components/BaseForm";
import { mapActions } from "vuex";
export default {
  components: {
    Modal,
    BaseForm
  },
  props: {
    title: {
      type: String,
      default: "编辑"
    },
    btnText: {
      type: String,
      default: "编辑"
    },
    btnSize: {
      type: String,
      default: "small"
    },
    btnType: {
      type: String,
      default: ""
    },
    beforeSubmit: {
      type: Function,
      default: data => data
    },
    beforeVerify: {
      type: Function,
      default: data => true
    },
    module: String,
    formItem: Array,
    current: Object,
    getFormData: Function,
    ids: Array,
    isBatch: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    ...mapActions(["update", "updateBatch"]),
    getData() {
      this.$emit("get-data");
    },
    onBeforeOpen() {
      if (this.isBatch && this.ids.length === 0) {
        this.$util.msg.warning("没有选中项！");
        return false;
      }
      return true;
    },
    submit() {
      this.$refs.baseForm.submit();
    },
    reset() {
      // 需要异步执行 否则无法调用 baseForm.reset 方法
      setTimeout(() => {
        this.$refs.baseForm.reset();
      }, 0);
    },
    async handleSubmit(data) {
      if (!this.beforeVerify(data)) {
        return;
      }
      data = this.beforeSubmit(data);
      let res = null;
      if (this.isBatch) {
        res = await this.updateBatch({
          module: this.module,
          ids: this.ids,
          data
        });
      } else {
        res = await this.update({
          module: this.module,
          data: {
            ...data,
            id: this.current.id
          }
        });
      }
      if (res) {
        this.$util.msg.success("更新成功");
        this.$emit("get-data");
        this.$emit("success");
        this.$refs.modal.hidden();
        this.$emit("get-data");
      }
    }
  },
  computed: {
    formData() {
      return this.getFormData ? this.getFormData() : this.current;
    }
  }
};
</script>
