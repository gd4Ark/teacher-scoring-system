<template>
  <div class="app-container">
    <v-card title="添加学生">
      <add :formItem="$v_data.student.form.item"
           :getFormData="$v_data.student.form.data"
           module="student"
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