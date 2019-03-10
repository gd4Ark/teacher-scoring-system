<template>
  <c-form :form-item="formItem"
          :form-data="s_formData">
    <el-form-item>
      <slot></slot>
      <el-button size="small"
                 type="primary"
                 @click="submit">{{
        btn
        }}</el-button>
    </el-form-item>
  </c-form>
</template>
<script>
import cForm from "@/common/components/Form";
export default {
  components: {
    cForm
  },
  props: {
    formItem: Array,
    formData: {
      type: Object,
      default: null
    },
    getFormData: Function,
    btn: {
      type: String,
      default: "提交"
    }
  },
  data: () => ({
    s_formData: null
  }),
  mounted() {
    this.resetData();
  },
  methods: {
    resetData() {
      this.s_formData = this.formData || this.getFormData();
    },
    submit() {
      if (this.$util.checkEmptyForm(this.s_formData)) {
        return this.$util.msg.warning("请填写完整！");
      }
      this.$emit("submit", this.s_formData);
    }
  }
};
</script>