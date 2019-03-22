<template>
  <div :style="{width:'40%'}">
    <baseForm ref="baseForm"
              :btn-text="btnText"
              :form-item="formItem"
              :form-data="current"
              @submit="handleSubmit">
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
    current: Object,
    module: {
      type: String,
      default: ""
    },
    btnText: {
      type: String,
      default: "更新"
    }
  },
  methods: {
    ...mapActions(["update"]),
    async handleSubmit(formData) {
      if (!this.module) {
        return this.$emit("submit", formData);
      }
      const id = await this.update({
        module: this.module,
        data: formData
      });
      if (id) {
        this.$util.msg.success("更新成功");
        this.$emit("get-data");
        this.$emit("success");
      }
    }
  }
};
</script>