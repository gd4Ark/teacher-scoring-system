<template>
  <div :class="['wrapper',device,classObj]">
    <transition name="el-fade-in">
      <div v-show="isMobile && sidebar.opened"
           class="drawer-bg"
           @click="handleClickOutside" />
    </transition>
    <div :class="['sidebar']">
      <v-aside />
    </div>
    <div class="container">
      <v-header />
      <div class="app-content">
        <transition name="el-fade-in">
          <router-view v-show="load"
                       :key="$route.fullPath" />
        </transition>
        <v-footer />
      </div>
    </div>
  </div>
</template>
<script>
import vHeader from './Header'
import vAside from './Aside'
import vFooter from './Footer'
import { mapGetters } from 'vuex'
export default {
  components: {
    vHeader,
    vAside,
    vFooter
  },
  data: () => ({
    load: false
  }),
  computed: {
    ...mapGetters(['device', 'sidebar', 'isMobile']),
    classObj() {
      return {
        hideSidebar: !this.sidebar.opened,
        openSidebar: this.sidebar.opened,
        mobile: this.isMobile
      }
    }
  },
  mounted() {
    this.load = true
  },
  methods: {
    handleClickOutside() {
      this.$store.dispatch('app/toggleSidebar')
    }
  }
}
</script>
<style lang="scss" scoped>
.wrapper {
  position: relative;
  @include wh(100%);
  background: #f2f2f2;
  &.desktop {
    &.openSidebar {
      .sidebar {
        width: $sidebar-width;
      }
      .container {
        margin-left: $sidebar-width;
      }
    }
    &.hideSidebar {
      .sidebar {
        width: 0;
      }
      .container {
        margin-left: 0;
      }
    }
  }
  &.mobile {
    .container {
      margin-left: 0;
    }
    &.hideSidebar {
      .sidebar {
        transform: translate3d(-$sidebar-width, 0, 0);
      }
    }
  }
}

.drawer-bg {
  @include mask(1000);
}

.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  z-index: 1001;
  background: $sidebar-color;
  overflow: hidden;
  transition: width 0.28s, transform 0.28s;
}
.container {
  @include flex-column;
  overflow: hidden;
  height: 100%;
  transition: margin-left 0.28s;
  > * {
    width: 100%;
  }
  .app-content {
    @include flex-column;
    @include padding;
    flex: 1;
    padding-bottom: 0;
    overflow: hidden;
  }
  .inner-container {
    @include no-scrollbar;
    @include flex-column;
    flex: 1;
    overflow: hidden;
  }
}
</style>
