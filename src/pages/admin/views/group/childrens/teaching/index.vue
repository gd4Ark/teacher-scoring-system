<template>
  <not-sub-router name="teaching">
    <teaching-table @get-data="getData" />
  </not-sub-router>
</template>
<script>
import TeachingTable from "@/pages/admin/tables/TeachingTable";
import { mapActions, mapMutations } from "vuex";
export default {
  components: {
    TeachingTable
  },
  methods: {
    ...mapActions({
      getData: "getTeaching"
    }),
    ...mapMutations({
      setData: "teaching"
    })
  },
  created() {
    this.setData({
      group_id: this.$route.params.group_id
    });
    this.getData();
  }
};
</script>
