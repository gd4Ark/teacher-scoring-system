<template>
  <div :style="{width:'40%'}">
    <baseForm ref="baseForm"
              :use-btn="useBtn"
              :btn-text="btnText"
              :form-item="formItem"
              :get-form-data="getFormData"
              @submit="submit">
      <slot></slot>
    </baseForm>
  </div>
</template>
<script>
import BaseForm from "@/common/components/BaseForm";
import { mapActions } from "vuex";
export default {
  components: {
    BaseForm
  },
  props: {
    formItem: Array,
    getFormData: Function,
    beforeSubmit: {
      type: Function,
      default: data => data
    },
    beforeVerify: {
      type: Function,
      default: data => true
    },
    module: {
      type: String,
      default: ""
    },
    useBtn: {
      type: Boolean,
      default: true
    },
    btnText: {
      type: String,
      default: "添加"
    }
  },
  methods: {
    ...mapActions(["add"]),
    resetData() {
      this.$refs.baseForm.reset();
    },
    async submit(data) {
      if (!this.module) {
        return this.$emit("submit", data);
      }
      if (!this.beforeVerify(data)) {
        return;
      }
      data = this.beforeSubmit(data);
      const res = await this.add({
        module: this.module,
        data
      });
      if (res) {
        this.$util.msg.success("添加成功！");
        this.resetData();
        this.$emit("success");
      }
    }
  }
};
</script>