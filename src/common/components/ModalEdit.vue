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
              @submit="handleEdit" />
  </modal>
</template>
<script>
import Modal from "@/common/components/Modal";
import BaseForm from "@/common/components/BaseForm";
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
    reset(){
      // 需要异步执行 否则无法调用 baseForm.reset 方法
      setTimeout(()=>{
        this.$refs.baseForm.reset();
      },0);
    },
    handleEdit(formData) {
      console.log(this.current);
    }
  },
  computed: {
    formData() {
      return this.getFormData ? this.getFormData() : this.current;
    }
  }
};
</script>
