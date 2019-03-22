<template>
  <not-sub-router name="subject">
    <search module="subject" />
    <subject-table />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import SubjectTable from "@/pages/admin/tables/SubjectTable";
import { mapActions } from "vuex";
export default {
  components: {
    SubjectTable,
    Search
  },
  ...mapActions({
    // getData: "getSubject"
  })
};
</script>
