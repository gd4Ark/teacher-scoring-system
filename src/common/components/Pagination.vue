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
    ...mapGetters(['device','isMobile']),
    layout() {
      return this.isMobile ? this.state.small_layout : this.state.layout
    },
    total() {
      return this.state.total
    },
    pagerCount() {
      return this.state.pager_count
    },
    pageSizes(){
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