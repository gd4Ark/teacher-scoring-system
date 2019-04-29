<template>
  <el-pagination background
                 :small="isMobile"
                 :layout="layout"
                 :total="total"
                 :pager-count="pagerCount"
                 :current-page.sync="currentPage"
                 :page-size.sync="perPage"
                 :page-sizes="pageSizes" />
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  name: 'Pagination',
  props: {
    state: Object,
    module: String
  },
  methods: {
    getData() {
      this.$emit('get-data')
    }
  },
  computed: {
    ...mapGetters(['device', 'isMobile']),
    layout() {
      return this.isMobile ? this.state.small_layout : this.state.layout
    },
    total() {
      return this.state.total
    },
    pagerCount() {
      return this.state.pager_count
    },
    pageSizes() {
      return this.state.page_sizes
    },
    currentPage: {
      get() {
        return this.state.current_page
      },
      set(value) {
        this.$store.commit(`${this.module}/currentPage`, value)
        this.getData()
      }
    },
    perPage: {
      get() {
        return this.state.per_page
      },
      set(value) {
        this.$store.commit(`${this.module}/sizeChange`, value)
        this.getData()
      }
    }
  }
}
</script>
<style lang="scss">
.el-pagination {
  margin-top: 1.5vh;
  @include sub-center;
  justify-content: space-around;
}
.el-pagination__jump {
  margin-left: 3px;
}
.el-pagination--small {
  .el-pagination__sizes {
    .el-input--mini .el-input__inner {
      font-size: 0.9rem;
      height: 22px;
      line-height: 20px;
    }
  }
}

.el-pagination button,
.el-pagination span:not([class*='suffix']) {
  font-size: 0.9rem;
}
</style>
