<template>
  <div class="app-container">
    <v-card title="添加教师">
      <add :formItem="$v_data.tearcher.add.item"
           :getFormData="$v_data.tearcher.add.data"
           module="tearcher"
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