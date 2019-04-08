<template>
  <not-sub-router name="teaching">
    <search module="teaching"
            @get-data="getData" />
    <teaching-table @get-data="getData" />
  </not-sub-router>
</template>
<script>
import Search from "@/common/components/Search";
import TeachingTable from "@/pages/admin/tables/TeachingTable";
import { mapActions, mapMutations } from "vuex";
export default {
  components: {
    TeachingTable,
    Search
  },
  methods: {
    ...mapActions({
      getData: "getTeaching"
    }),
    ...mapMutations({
      setData: "teaching"
    })
  },
  created() {
    this.setData({
      group_id: this.$route.params.group_id
    });
    this.getData();
  }
};
</script>
