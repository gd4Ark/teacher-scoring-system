<template>
  <div class="app-container">
    <v-card title="添加班级">
      <add :form-item="$v_data.group.add.item"
           :get-form-data="$v_data.group.add.data"
           :before-submit="splitNameList"
           module="group"
           :style="{width:'50%'}">
      </add>
    </v-card>
  </div>
</template>
<script>
import Add from "@/common/components/Add";
import splitNameList from "@/common/mixins/splitNameList";
export default {
  mixins: [splitNameList],
  components: {
    Add
  }
};
</script>