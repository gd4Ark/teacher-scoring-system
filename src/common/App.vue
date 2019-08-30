<template>
  <div id="app">
    <router-view v-if="isRouterAlive" />
  </div>
</template>
<script>
import ResizeHandler from '@/common/mixins/ResizeHandler.js'
import { hasPermission } from '@/common/utils/role'
import { mapGetters, mapActions, mapMutations } from 'vuex'
export default {
  mixins: [ResizeHandler],
  data() {
    return {
      isRouterAlive: true
    }
  },
  computed: {
    ...mapGetters(['device', 'meRole', 'root'])
  },
  watch: {
    $route(route) {
      this.checkRootRoute(route)
    },
    device() {
      this.setHTMLClass()
    }
  },
  created() {
    this.initNavList()
  },
  mounted() {
    this.setHTMLClass()
  },
  methods: {
    ...mapActions('app', ['updateNavList', 'updateSearchList']),
    ...mapMutations('app', ['updateRoot']),
    checkRootRoute(route) {
      let routes = this.$router.options.routes
      let parent = { name: '' }
      const first = route.matched[0]
      const isRoot = this._.get(first, 'meta.root')
      if (isRoot) {
        routes = routes.find(item => item.name === first.name).children
        parent = first
      }
      if (this.root !== parent.name) {
        this.updateRoot(parent.name)
        this.initNavList(routes, parent)
      }
    },
    initNavList(routes = null, parent = null) {
      routes = routes || this.$router.options.routes
      const navList = this._.cloneDeep(routes)
      const res = this.filterNavList(navList, parent)
      const search = this.initSearch(res)
      this.updateNavList(res)
      this.updateSearchList(search)
    },
    initSearch(navList, parent = null) {
      let res = []
      navList.forEach(item => {
        let title = [item.meta.title]
        if (parent) {
          title = [parent.meta.title].concat(title)
        }
        res.push({
          title: title,
          path: item.path
        })
        if (item.children) {
          res = res.concat(this.initSearch(item.children, item))
        }
      })
      return res
    },
    filterNavList(list, parent = null) {
      const res = list.map(item => {
        if (item.hidden) return null
        if (item.single) {
          item = {
            ...item.children[0],
            path: item.redirect
          }
        } else if (parent) {
          item.path = parent.path + '/' + item.path
        }
        if (this._.get(item, 'meta.roles')) {
          if (!hasPermission(this.meRole, item)) {
            return null
          }
        }
        if (item.children) {
          item.children = this.filterNavList(item.children, item)
          if (!item.children.length) {
            delete item.children
          }
        }
        const keys = ['path', 'name', 'meta', 'children']
        const newItem = {}
        for (const key of Object.keys(item)) {
          if (keys.includes(key)) {
            newItem[key] = item[key]
          }
        }
        return newItem
      })
      return res.filter(item => item)
    },
    setHTMLClass() {
      document.querySelector('html').className = this.device
    },
    reload() {
      this.isRouterAlive = false
      this.$nextTick(() => {
        this.isRouterAlive = true
      })
    }
  }
}
</script>

<style lang="scss">
@import '@/common/styles/_reset.scss';
</style>
