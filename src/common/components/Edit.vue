<template>
  <div :style="width">
    <baseForm ref="baseForm"
              :btn="btnText"
              :form-item="formItem"
              :form-data="current"
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
    current: Object,
    action: {
      type: String,
      default: ""
    },
    btnText: {
      type: String,
      default: "更新"
    }
  },
  methods: {
    async submit(formData) {
      if (!this.action) {
        return this.$emit("submit", formData);
      }
      const id = await this.$store.dispatch(this.action, formData);
      if (id) {
        this.$util.msg.success("更新成功");
        this.$emit("get-data");
        this.$emit("success");
      }
    }
  }
};
</script>