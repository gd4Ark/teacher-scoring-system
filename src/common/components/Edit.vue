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
      default: "更新"
    }
  },
  methods: {
    ...mapActions(["update"]),
    async handleSubmit(data) {
      if (!this.module) {
        return this.$emit("submit", data);
      }
      if (!this.beforeVerify(data)) {
        return;
      }
      data = this.beforeSubmit(data);
      const res = await this.update({
        module: this.module,
        data: {
          id: this.current.id,
          ...data
        }
      });
      if (res) {
        const message = this.successMessage(res) || "更新成功！";
        this.$util.msg.success(message);
        this.$emit("get-data");
        this.$emit("success");
      }
    }
  }
};
</script>