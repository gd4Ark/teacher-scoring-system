<template>
  <not-sub-router name="index">
    <search module="score" />
    <score-table />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import ScoreTable from "@/pages/admin/tables/ScoreTable";
import { mapActions } from "vuex";
export default {
  components: {
    ScoreTable,
    Search
  },
  ...mapActions({
    // getData: "getTearcher"
  })
};
</script>
