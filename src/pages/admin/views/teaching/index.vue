<template>
  <not-sub-router name="teaching">
    <search module="teaching" />
    <teaching-table />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import TeachingTable from "@/pages/admin/tables/TeachingTable";
import { mapActions } from "vuex";
export default {
  components: {
    TeachingTable,
    Search
  },
  ...mapActions({
    // getData: "getCourse"
  })
};
</script>
