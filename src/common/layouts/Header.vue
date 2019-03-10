<template>
  <div class="app-header">
    <h1 class="title">
      <router-link to="/index">{{ $config.app_title }}</router-link>
    </h1>
    <div class="header-navbar">
      <slot name="header-navbar"></slot>
      <div class="header-userpannel">
        <el-dropdown trigger="click">
          <p class="el-dropdown-link">
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
  </div>
</template>
<script>
import { mapActions } from "vuex";
import CurrentUser from "@/common/mixins/CurrentUser";
export default {
  mixins: [CurrentUser],
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
  .header-navbar {
    @include flex;
    .header-userpannel {
      margin-left: 30px;
      .el-dropdown-link {
        cursor: pointer;
        color: white;
        @include no-user-select;
      }
    }
  }
}
</style>
