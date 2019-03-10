<template>
  <not-sub-router name="tearcher">
    <tearcher-table />
  </not-sub-router>
</template>
<script>
import TearcherTable from "@/pages/admin/components/TearcherTable";
export default {
  components: {
    TearcherTable,
  }
};
</script>
