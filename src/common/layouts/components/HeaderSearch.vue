<template>
  <div :class="{ 'show': show }"
       class="header-search">
    <div class-name="search-icon"
         @click.stop="click">
      <i class="search-icon el-icon-ali-search1"></i>
    </div>
    <el-select ref="headerSearchSelect"
               v-model="search"
               :remote-method="querySearch"
               filterable
               default-first-option
               remote
               placeholder="搜索"
               class="header-search-select"
               @change="change">
      <el-option v-for="item in options"
                 :key="item.path"
                 :value="item"
                 :label="item.title.join(' > ')" />
    </el-select>
  </div>
</template>

<script>
import Fuse from 'fuse.js'
import { mapGetters } from 'vuex'
export default {
  name: 'HeaderSearch',
  data() {
    return {
      search: '',
      options: [],
      searchPool: [],
      show: false,
      fuse: undefined
    }
  },
  computed: {
    ...mapGetters(['searchList'])
  },
  watch: {
    show(value) {
      if (value) {
        document.body.addEventListener('click', this.close)
      } else {
        document.body.removeEventListener('click', this.close)
      }
    }
  },
  created() {
    this.initFuse(this.searchList)
  },
  methods: {
    click() {
      this.show = !this.show
      if (this.show) {
        this.$refs.headerSearchSelect && this.$refs.headerSearchSelect.focus()
      }
    },
    close() {
      this.$refs.headerSearchSelect && this.$refs.headerSearchSelect.blur()
      this.options = []
      this.show = false
    },
    change(val) {
      this.$router.push(val.path)
      this.search = ''
      this.options = []
      this.$nextTick(() => {
        this.show = false
      })
    },
    initFuse(list) {
      this.fuse = new Fuse(list, {
        shouldSort: true,
        threshold: 0.4,
        location: 0,
        distance: 100,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
          {
            name: 'title',
            weight: 0.7
          },
          {
            name: 'path',
            weight: 0.3
          }
        ]
      })
    },
    querySearch(query) {
      if (query !== '') {
        this.options = this.fuse.search(query)
      } else {
        this.options = []
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.header-search {
  .search-icon {
    font-size: $header-icon-size;
    padding: $header-icon-padding;
    cursor: pointer;
  }

  .header-search-select {
    font-size: 18px;
    transition: width 0.2s;
    width: 0;
    overflow: hidden;
    background: transparent;
    border-radius: 0;
    display: inline-block;
    vertical-align: middle;
    color: white;

    /deep/ .el-input__inner {
      border: 0;
      border-bottom: 1px solid #d9d9d9;
      padding-left: 0.5em;
      padding-right: 0;
      box-shadow: none !important;
      background: transparent;
      vertical-align: middle;
      color: inherit;
    }
  }

  &.show {
    .header-search-select {
      width: 180px;
      margin-left: 10px;
    }
  }
}
</style>
