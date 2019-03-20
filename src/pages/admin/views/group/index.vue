<template>
  <not-sub-router name="group">
    <group-table />
  </not-sub-router>
</template>
<script>
import GroupTable from "@/pages/admin/tables/GroupTable";
export default {
  components: {
    GroupTable,
  }
};
</script>
