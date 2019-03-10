<template>
  <div :style="{width:width}">
    <baseForm ref="baseForm"
              :btn="btnText"
              :form-item="formItem"
              :get-form-data="getFormData"
              @submit="submit">
      <slot></slot>
    </baseForm>
  </div>
</template>
<script>
import BaseForm from "@/common/components/BaseForm";
export default {
  components: {
    BaseForm
  },
  props: {
    width: {
      type: String,
      default: "40%"
    },
    formItem: Array,
    getFormData: Function,
    action: {
      type: String,
      default: ""
    },
    btnText: {
      type: String,
      default: "添加"
    }
  },
  methods: {
    async submit(formData) {
      if (!this.action) {
        return this.$emit("submit", formData);
      }
      const id = await this.$store.dispatch(this.action, formData);
      if (id) {
        this.$util.msg.success("添加成功！");
        this.$refs.baseForm.resetData();
        this.$emit("success");
      }
    }
  }
};
</script>