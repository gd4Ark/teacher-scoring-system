<template>
  <not-sub-router name="tearcher">
    <search module="tearcher" />
    <tearcher-table />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import TearcherTable from "@/pages/admin/tables/TearcherTable";
import { mapActions } from "vuex";
export default {
  components: {
    TearcherTable,
    Search
  },
  ...mapActions({
    // getData: "getTearcher"
  })
};
</script>
