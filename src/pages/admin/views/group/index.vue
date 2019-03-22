<template>
  <not-sub-router name="group">
    <search module="group" />
    <group-table />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import GroupTable from "@/pages/admin/tables/GroupTable";
import { mapActions } from "vuex";
export default {
  components: {
    GroupTable,
    Search
  },
  ...mapActions({
    // getData: "getGroup"
  })
};
</script>
