<template>
  <v-card :title="title">
    <div class="toolbar"
         slot="toolbar">
      <el-button size="small"
                 type="primary"
                 @click="submit">搜索</el-button>
      <el-button size="small"
                 type="info"
                 @click="handleReset">重置</el-button>
    </div>
    <c-form :inline="true"
            :form-item="formItem"
            :form-data="formData" />
  </v-card>
</template>
<script>
import cForm from "@/common/components/Form";
import { mapActions } from "vuex";
export default {
  components: {
    cForm
  },
  props: {
    title: {
      type: String,
      default: "搜索"
    },
    module: String
  },
  data: () => ({
    searchKeyword: []
  }),
  mounted() {
    // this.reset();
  },
  methods: {
    ...mapActions(["resetSearchData", "updateSearchKeyword"]),
    reset() {
      this.resetSearchData(this.module);
    },
    handleReset() {
      this.reset();
      this.submit();
    },
    submit() {
      this.searchKeyword = [];
      this.formItem.forEach(el => {
        const key = el.key;
        let item = this.formData[key];
        if (el.items) {
          el.items.forEach((el, index) => {
            if (item[index] !== 0 && !item[index]) return;
            this.searchKeyword.push([key, el.operation, item[index]]);
          });
        } else {
          if (item !== 0 && !item) return;
          const operation = el.operation;
          if (operation === "like") {
            item = `%${item}%`;
          }
          this.searchKeyword.push([key, operation, item]);
        }
      });
      this.handleSubmit();
    },
    async handleSubmit() {
      await this.updateSearchKeyword({
        module: this.module,
        searchKeyword: this.searchKeyword
      });
      this.$emit("get-data");
    }
  },
  computed: {
    submitAction() {
      return `${this.module}searchKeyword`;
    },
    formItem() {
      return this.$vData[this.module].search.item;
    },
    formData() {
      return this.$store.state[this.module].searchData;
    },
    s_module() {
      return this.$util.firstUpperCase(this.module);
    }
  }
};
</script>
