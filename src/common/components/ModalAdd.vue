<template>
  <modal ref="modal"
         :title="title"
         :btn-text="btnText"
         :btn-size="btnSize"
         :btn-type="btnType"
         @submit="submit"
         @open="reset">
    <baseForm slot="body"
              ref="baseForm"
              :use-btn="false"
              :btn-text="btnText"
              :form-item="formItem"
              :get-form-data="getFormData"
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
      default: "添加"
    },
    btnText: {
      type: String,
      default: "添加"
    },
    btnSize: {
      type: String,
      default: "small"
    },
    btnType: {
      type: String,
      default: "primary"
    },
    beforeSubmit: {
      type: Function,
      default: data => data
    },
    beforeVerify: {
      type: Function,
      default: data => true
    },
    successMessage: {
      type: Function,
      default: data => null
    },
    module: String,
    formItem: Array,
    getFormData: Function
  },
  methods: {
    ...mapActions(["add"]),
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
      const res = await this.add({
        module: this.module,
        data
      });
      if (res) {
        const message = this.successMessage(res) || "添加成功！";
        this.$util.msg.success(message);
        this.$emit("get-data");
        this.$emit("success");
        this.$refs.modal.hidden();
      }
    }
  }
};
</script>
