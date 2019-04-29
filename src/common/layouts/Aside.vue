<template>
  <div class="app-aside">
    <div class="title-container">
      <h1 class="title">
        <router-link to="/index">{{ $config.app_title }}</router-link>
      </h1>
    </div>
    <el-menu :default-active="activeIndex"
             class="el-menu-vertical"
             unique-opened
             router>
      <template v-for="item of navList">
        <el-submenu v-if="item.subs"
                    :index="item.index"
                    :key="item.index">
          <template slot="title">
            <i v-if="item.icon"
               :class="item.icon"></i>
            <span>{{ item.title }}</span>
          </template>
          <el-menu-item v-for="subItem of item.subs"
                        :index="subItem.index"
                        :key="subItem.index">
            <i v-if="subItem.icon"
               :class="subItem.icon"></i>
            <span>{{ subItem.title }}</span>
          </el-menu-item>
        </el-submenu>
        <el-menu-item v-else
                      :index="item.index"
                      :key="item.index">
          <i v-if="item.icon"
             :class="item.icon"></i>
          <span>{{ item.title }}</span>
        </el-menu-item>
      </template>
    </el-menu>
  </div>
</template>

<script>
export default {
  data: () => ({
    activeIndex: ''
  }),
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
      this.activeIndex = this.$route.matched[1].path
    }
  },
  computed: {
    navList() {
      return this.$router.options.navList
    }
  }
}
</script>

<style lang="scss" scoped>
.app-aside {
  @include wh(220px, 100%);
  @include flex-column;
  & > .el-menu {
    flex: 1;
    box-shadow: 4px 1px 12px rgba(0, 55, 107, 0.04);
    overflow-y: auto;
    @include no-scrollbar;
  }
}
.title-container {
  @include wh(100%, 62px);
  @include sub-center;
  background: white;
  background: $gighlight-color;
  color: white;
  .title {
    font-size: 1.5rem;
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
  .el-menu-item,
  .el-submenu__title {
    font-size: 0.9rem;
  }
}
</style>
