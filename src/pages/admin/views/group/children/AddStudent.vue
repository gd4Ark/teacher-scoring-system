<template>
  <div class="app-container">
    <v-card :title="$route.meta.title">
      <add :formItem="$vData.group.student.item"
           :getFormData="$vData.group.student.data"
           action="addStudent">
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