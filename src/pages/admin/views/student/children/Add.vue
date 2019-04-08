<template>
  <div class="app-container">
    <v-card :title="title">
      <add :form-item="$v_data[module].add.item"
           :get-form-data="$v_data[module].add.data"
           :before-submit="_splitNameList"
           :success-message="successMessage"
           :style="{width:'50%'}"
           :module="module" />
    </v-card>
  </div>
</template>
<script>
import Add from "@/common/components/Add";
import splitNameList from "@/common/mixins/splitNameList";
import successMessage from "@/common/mixins/successMessage";
export default {
  mixins: [splitNameList, successMessage],
  components: {
    Add
  },
  data: () => ({
    module: "student",
    title: "添加学生"
  }),
  methods: {
    _splitNameList(data) {
      const nameList = this.splitNameList(data);
      nameList.forEach(el => {
        el.group_id = this.$route.params.group_id;
      });
      return nameList;
    }
  }
};
</script>