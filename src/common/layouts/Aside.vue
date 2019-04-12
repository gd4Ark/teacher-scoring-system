<template>
  <div class="app-aside">
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
    activeIndex: ""
  }),
  watch: {
    $route() {
      this.updateActive();
    }
  },
  mounted() {
    this.updateActive();
  },
  beforeUpdate() {
    this.updateActive();
  },
  methods: {
    updateActive() {
      this.activeIndex = this.$route.matched[1].path;
    }
  },
  computed: {
    navList() {
      return this.$router.options.navList;
    }
  }
};
</script>

<style lang="scss" scoped>
.app-aside {
  width: 13%;
  padding-top: 20px;
  position: relative;
  z-index: 1;
  background: #f7f7f7;
  box-shadow: 4px 1px 12px rgba(0, 55, 107, 0.04);
}
span {
  @include no-user-select;
}
</style>
