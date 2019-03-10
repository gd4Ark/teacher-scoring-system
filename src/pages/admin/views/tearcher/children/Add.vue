<template>
  <div class="app-container">
    <v-card :title="$route.meta.title">
      <add :formItem="$vData.tearcher.base.item"
           :getFormData="$vData.tearcher.base.data"
           action="addTearcher">
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