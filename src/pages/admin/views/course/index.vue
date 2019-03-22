<template>
  <not-sub-router name="course">
    <search module="course" />
    <course-table />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import CourseTable from "@/pages/admin/tables/CourseTable";
import { mapActions } from "vuex";
export default {
  components: {
    CourseTable,
    Search
  },
  ...mapActions({
    // getData: "getCourse"
  })
};
</script>
