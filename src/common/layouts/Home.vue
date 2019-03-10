<template>
  <div class="wrapper">
    <v-header />
    <div class="content-box">
      <v-aside />
      <div id="content">
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
    padding-bottom: 0;
    flex: 1;
    background: #f2f2f2;
  }
  .app-container {
    @include no-scrollbar;
    flex: 1;
    margin-bottom: 1%;
    overflow-y: auto;
  }
}
</style>
