<template>
  <c-form v-if="sformData!==null"
          :form-item="formItem"
          :form-data="sformData"
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
import { clone, retainKeys } from "@/common/utils";
export default {
  name: "BaseForm",
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
    sformData: null
  }),
  mounted() {
    this.reset();
  },
  methods: {
    reset() {
      this.sformData = this.formData
        ? clone(this.formData)
        : this.getFormData();
    },
    submit() {
      this.$refs.form.submit();
    },
    handleSubmit() {
      const data = retainKeys(this.sformData, this.getKeys());
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