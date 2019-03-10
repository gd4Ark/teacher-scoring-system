<template>
  <div class="app-container">
    <v-card :title="$route.meta.title">
      <add :formItem="$vData.group.base.item"
           :getFormData="$vData.group.base.data"
           action="addGroup">
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