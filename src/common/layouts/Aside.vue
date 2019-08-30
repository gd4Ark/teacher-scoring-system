<template>
  <div class="app-aside">
    <div class="title-container">
      <h1 class="title">
        <router-link to="/index">{{ title }}</router-link>
      </h1>
    </div>
    <el-menu v-if="!_.isEmpty(navList)"
             :default-active="activeIndex"
             class="el-menu-vertical"
             router>
      <template v-for="(item,index) of navList">
        <v-menu :key="index"
                :item="item" />
      </template>
    </el-menu>
  </div>
</template>

<script>
import vMenu from './components/vMenu'
import { mapGetters } from 'vuex'
export default {
  components: {
    vMenu
  },
  data: () => ({
    activeIndex: ''
  }),
  computed: {
    ...mapGetters(['title', 'navList'])
  },
  watch: {
    $route() {
      this.updateActive()
    }
  },
  mounted() {
    this.updateActive()
  },
  beforeUpdate() {
    this.updateActive()
  },
  methods: {
    updateActive() {
      const activeIndex = this.$route.matched.find(item => {
        return !item.redirect
      }).path
      if (this.activeIndex !== activeIndex) {
        this.activeIndex = activeIndex
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.app-aside {
  @include wh($sidebar-width, 100%);
  @include flex-column;
  & > .el-menu {
    flex: 1;
    box-shadow: 4px 1px 12px rgba(0, 55, 107, 0.04);
    overflow-y: auto;
    @include no-scrollbar;
  }
}
.title-container {
  @include wh(100%, $app-header-height);
  @include sub-center;
  background: $app-header-bgcolor;
  color: $app-header-color;
  .title {
    font-size: $title-font-size;
  }
}
span {
  @include no-user-select;
}
</style>
<style lang="scss">
.el-menu {
  background: transparent;
  border: none;
  overflow: hidden;
  .el-submenu__title {
    color: $app-menu-item-color;
  }
  .el-menu-item {
    background: $sidebar-color;
    color: $app-menu-item-color;
    &.is-active {
      color: $app-menu-item-active-color;
    }
  }
  .sub-item-item {
    background: $app-sub-menu-item-bgcolor;
  }
  .el-menu-item,
  .el-submenu__title {
    font-size: 0.9rem;
    @include no-user-select;
  }
  .el-menu-item,
  .el-submenu__title,
  .el-submenu .el-menu-item {
    height: $app-menu-item-height;
    line-height: $app-menu-item-height;
    transition: background 0.5s ease;
  }
  .el-menu-item:hover,
  .el-submenu__title:hover,
  .el-menu-item:focus,
  .el-submenu__title:focus {
    background: $app-menu-item-hover-bgcolor;
  }
  .el-menu-item [class^='el-icon-'],
  .el-submenu [class^='el-icon-'] {
    font-size: 1.2rem;
  }
}
</style>
