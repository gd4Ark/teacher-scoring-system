<template>
  <div class="wrapper">
    <v-header />
    <div class="content-box">
      <v-aside />
      <div id="content">
        <breadcrumb class="breadcrumb-container" />
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
import Breadcrumb from "@/common/components/Breadcrumb";
export default {
  components: {
    vHeader,
    vAside,
    vFooter,
    Breadcrumb
  },
  data: () => ({
    load: false
  }),
  mounted() {
    this.load = true;
  }
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
    @include padding;
    padding-top: 0;
    flex: 1;
    padding-bottom: 0;
    background: #f2f2f2;
    overflow: hidden;
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
