<template>
  <div class="app-container">
    <v-card title="添加科目">
      <add :form-item="$v_data.subject.add.item"
           :get-form-data="$v_data.subject.add.data"
           :before-submit="splitNameList"
           module="subject"
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