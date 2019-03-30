<template>
  <c-form v-if="s_formData!==null"
          :form-item="formItem"
          :form-data="s_formData"
          @submit="handleSubmit"
          ref="form">
    <el-form-item>
      <slot></slot>
      <el-button v-if="useBtn"
                 size="small"
                 type="primary"
                 @click="submit">{{
        btnText
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
    useBtn: {
      type: Boolean,
      default: true
    },
    btnText: {
      type: String,
      default: "提交"
    }
  },
  data: () => ({
    s_formData: null
  }),
  mounted() {
    this.reset();
  },
  methods: {
    reset() {
      this.s_formData = this.formData
        ? this.$util.clone(this.formData)
        : this.getFormData();
    },
    submit() {
      this.$refs.form.submit();
    },
    handleSubmit() {
      const data = this.$util.retainKeys(this.s_formData, this.getKeys());
      this.$emit("submit", data);
    },
    getKeys() {
      let keys = [];
      this.formItem.forEach(el => {
        if (el.items) {
          return (keys = [...keys, ...el.items.map(el => el.key)]);
        }
        return keys.push(el.key);
      });
      return keys;
    }
  }
};
</script>