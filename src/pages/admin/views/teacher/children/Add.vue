<template>
  <div class="app-container">
    <v-card title="添加教师">
      <add :form-item="$v_data.teacher.add.item"
           :get-form-data="$v_data.teacher.add.data"
           :before-submit="splitNameList"
           module="teacher"
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