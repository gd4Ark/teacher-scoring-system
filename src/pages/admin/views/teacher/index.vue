<template>
  <not-sub-router name="teacher">
    <search module="teacher"
            @get-data="getData" />
    <teacher-table @get-data="getData" />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import TeacherTable from "@/pages/admin/tables/TeacherTable";
import { mapActions } from "vuex";
export default {
  components: {
    TeacherTable,
    Search
  },
  methods: {
    ...mapActions({
      getData: "getTeacher"
    })
  }
};
</script>
