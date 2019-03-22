<template>
  <div class="app-container">
    <v-card title="添加科目">
      <add :formItem="$v_data.subject.form.item"
           :getFormData="$v_data.subject.form.data"
           module="subject"
           :style="{width:'50%'}">
      </add>
    </v-card>
  </div>
</template>
<script>
import Add from "@/common/components/Add";
export default {
  components: {
    Add
  }
};
</script>