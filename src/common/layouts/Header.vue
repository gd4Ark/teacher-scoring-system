<template>
  <div class="app-header">
    <h1 class="title">
      <router-link to="/index">{{ $config.app_title }}</router-link>
    </h1>
    <div class="right-menu">

      <screenfull class="right-menu-item hover-effect" />

      <el-dropdown class="avatar-container right-menu-item"
                   trigger="click">
        <p class="avatar-wrapper">
          admin
          <i class="el-icon-arrow-down el-icon--right"></i>
        </p>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item v-for="(item, index) in s_userMenuList"
                            :key="index">
            <router-link v-if="item.path"
                         :to="item.path">
              {{ item.label }}
            </router-link>
            <span v-else-if="item.click"
                  @click="item.click">
              {{ item.label }}
            </span>
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
  </div>
</template>
<script>
import Screenfull from "@/common/components/Screenfull";
import { success } from "@/common/utils/message";
import { mapActions } from "vuex";
export default {
  components: {
    Screenfull
  },
  props: {
    userMenuList: {
      type: Array,
      default: Array
    }
  },
  data: () => ({
    s_userMenuList: []
  }),
  mounted() {
    this.s_userMenuList = [
      ...this.userMenuList,
      {
        path: "/password",
        label: "修改密码"
      },
      {
        click: this.handleLogout,
        label: "退出"
      }
    ];
  },
  methods: {
    ...mapActions(["logout"]),
    async handleLogout() {
      await this.logout();
      await success("退出成功！");
      this.$router.push("/login");
    }
  }
};
</script>

<style lang="scss" scoped>
.app-header {
  @include padding-x;
  @include wh(100%, 62px);
  @include flex;
  align-items: center;
  justify-content: space-between;
  background: $gighlight-color;
  color: white;
  .title {
    font-size: 1.3rem;
  }
  .right-menu {
    @include flex;
    height: 100%;
    .right-menu-item {
      @include no-user-select;
      @include sub-center;
      @include padding;
      color: white;
      cursor: pointer;
    }
  }
}
</style>
