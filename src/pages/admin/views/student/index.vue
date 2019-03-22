<template>
  <not-sub-router name="student">
    <search module="student" />
    <student-table />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import StudentTable from "@/pages/admin/tables/StudentTable";
import { mapActions } from "vuex";
export default {
  components: {
    StudentTable,
    Search
  },
  ...mapActions({
    // getData: "getStudent"
  })
};
</script>
