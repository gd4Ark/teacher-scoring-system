<template>
  <not-sub-router name="student">
    <search module="student"
            @get-data="getData" />
    <student-table @get-data="getData" />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import StudentTable from "@/pages/admin/tables/StudentTable";
import { mapActions, mapMutations } from "vuex";
export default {
  components: {
    StudentTable,
    Search
  },
  methods: {
    ...mapActions({
      getData: "getStudent"
    }),
    ...mapMutations({
      setData: "student"
    })
  },
  created() {
    this.setData({
      group: this.$route.params.group
    });
  }
};
</script>
