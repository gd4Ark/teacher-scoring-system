<template>
  <div class="app-container">
    <v-card title="添加班级">
      <add :formItem="$v_data.group.form.item"
           :getFormData="$v_data.group.form.data"
           module="group"
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