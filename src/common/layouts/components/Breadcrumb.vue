<template>
  <el-breadcrumb class="app-breadcrumb"
                 separator-class="el-icon-arrow-right">
    <el-breadcrumb-item v-for="(item,index) in levelList"
                        :key="item.path">
      <span v-if="item.redirect === 'noredirect' || index === levelList.length - 1"
            class="no-redirect">{{
        item.meta.title }}</span>
      <a v-else
         class="link"
         @click.prevent="handleLink(item)">{{ item.meta.title }}</a>
    </el-breadcrumb-item>
  </el-breadcrumb>
</template>

<script>
import pathToRegexp from 'path-to-regexp'
export default {
  name: 'Breadcrumb',
  data: () => ({
    levelList: null
  }),
  watch: {
    $route() {
      this.getBreadcrumb()
    }
  },
  created() {
    this.getBreadcrumb()
  },
  methods: {
    getBreadcrumb() {
      let matched = this.$route.matched.filter(item => item.name)
      const first = matched[0]
      if (first && !first.meta.isIndex) {
        matched = [{ path: '/', meta: { title: '首页' }}].concat(matched)
      }
      this.levelList = matched.filter(
        item => item.meta && item.meta.title && item.meta.breadcrumb !== false
      )
      this.levelList.forEach((item, index) => {
        if (item.meta.getTitle) {
          item.meta.title = item.meta.getTitle(this.$store)
        }
      })
    },
    pathCompile(path) {
      // To solve this problem https://github.com/PanJiaChen/vue-element-admin/issues/561
      const { params } = this.$route
      const toPath = pathToRegexp.compile(path)
      return toPath(params)
    },
    handleLink(item) {
      const { redirect, path } = item
      if (redirect) {
        this.$router.push(redirect)
        return
      }
      this.$router.push(this.pathCompile(path))
    }
  }
}
</script>

<style lang="scss" scoped>
.app-breadcrumb.el-breadcrumb {
  display: inline-block;
  font-size: 0.85rem;
  line-height: $app-header-height;
  margin-left: 8px;
  .no-redirect {
    color: #eee;
    cursor: text;
  }
  .link {
    color: white;
  }
}
</style>
