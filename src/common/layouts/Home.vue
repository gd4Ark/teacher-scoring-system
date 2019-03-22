<template>
  <div class="wrapper">
    <v-header />
    <div class="content-box">
      <v-aside />
      <div id="content">
        <div class="breadcrumb">
          <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>活动管理</el-breadcrumb-item>
            <el-breadcrumb-item>活动列表</el-breadcrumb-item>
            <el-breadcrumb-item>活动详情</el-breadcrumb-item>
          </el-breadcrumb>
        </div>
        <transition name="el-fade-in">
          <router-view v-show="load"></router-view>
        </transition>
        <v-footer />
      </div>
    </div>
  </div>
</template>
<script>
import vHeader from "./Header";
import vAside from "./Aside";
import vFooter from "./Footer";
export default {
  components: {
    vHeader,
    vAside,
    vFooter
  },
  data: () => ({
    load: false
  }),
  mounted() {
    this.load = true;
  },
};
</script>
<style lang="scss" scoped>
.wrapper {
  @include wh(100%);
  @include flex-column;
}
.content-box {
  @include flex;
  flex: 1;
  > * {
    height: 100%;
  }
  #content {
    @include flex-column;
    @include padding-x;
    flex: 1;
    background: #f2f2f2;
    overflow: hidden;
    .breadcrumb {
      @include flex;
      align-items: center;
      height: 45px;
    }
  }
  .app-container {
    @include no-scrollbar;
    @include flex-column;
    flex: 1;
    // overflow-y: auto;
    overflow: hidden;
  }
}
</style>
