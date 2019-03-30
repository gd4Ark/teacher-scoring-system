<template>
  <not-sub-router name="group">
    <search module="group"
            @get-data="getData" />
    <group-table @get-data="getData" />
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
  methods: {
    ...mapActions({
      getData: "getGroup"
    })
  }
};
</script>
