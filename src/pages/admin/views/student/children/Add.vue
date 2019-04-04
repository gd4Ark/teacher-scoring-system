<template>
  <div class="app-container">
    <v-card title="添加学生">
      <add :form-item="$v_data.student.add.item"
           :get-form-data="$v_data.student.add.data"
           :before-submit="splitNameList"
           module="student"
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