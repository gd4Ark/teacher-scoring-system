<template>
  <div class="app-container">
    <v-card :title="title">
      <add ref="add"
           :formItem="formItem"
           :getFormData="getFormData"
           @submit="submit"
           :style="{width:'30%'}">
      </add>
    </v-card>
  </div>
</template>
<script>
import Add from "@/common/components/Add";
import { mapActions } from "vuex";
export default {
  components: {
    Add
  },
  props: {
    title: String,
    module: String,
    formItem: Array,
    getFormData: Function
  },
  methods: {
    ...mapActions(["uploadAdd"]),
    async submit(data) {
      const formData = new FormData();
      for (const key in data) {
        formData.append(key, data[key]);
      }
      const res = await this.uploadAdd({
        module: this.module,
        data: formData
      });
      this.$util.msg.success("添加成功！");
      this.$refs.add.resetData();
    }
  }
};
</script>
