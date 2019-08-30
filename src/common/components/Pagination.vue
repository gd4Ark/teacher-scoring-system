<template>
  <el-pagination :small="true"
                 :layout="layout"
                 :total="total"
                 :pager-count="pagerCount"
                 :current-page.sync="currentPage"
                 :page-size.sync="perPage"
                 :page-sizes="pageSizes"
                 background />
</template>
<script>
import getData from '@/common/mixins/getData'
import submitChange from '@/common/mixins/submitChange'
import { mapGetters } from 'vuex'
export default {
  name: 'Pagination',
  mixins: [getData, submitChange],
  props: {
    state: {
      type: Object,
      required: true
    },
    module: {
      type: String,
      required: true
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
      async set(value) {
        this.$store.commit(`${this.module}/currentPage`, value)
        this.beforeChange()
        await this.getData()
        this.afterChange()
      }
    },
    perPage: {
      get() {
        return this.state.per_page
      },
      async set(value) {
        this.$store.commit(`${this.module}/sizeChange`, value)
        this.beforeChange()
        await this.getData()
        this.afterChange()
      }
    }
  }
}
</script>
<style lang="scss">
.el-pagination {
    @include padding-x;
    margin: 0.8vh 0;
    @include sub-center;
    justify-content: flex-end;
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
