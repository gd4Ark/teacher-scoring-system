<template>
  <ul>
    <li v-for="(item,index) in Object.entries(columns)"
        :key="index">{{ item[1] }} : {{ data[item[0]] }}</li>
  </ul>
</template>
<script>
import { mapActions } from "vuex";
export default {
  props: {
    data: Object,
    columns: Object
  }
};
</script>
<style lang="scss" scoped>
li {
  line-height: 3;
}
</style>
