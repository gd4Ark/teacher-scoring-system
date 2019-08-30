<template>
  <el-submenu v-if="item.children"
              :key="item.name"
              :index="item.path">
    <template slot="title">
      <i v-if="item.meta.icon"
         :class="item.meta.icon" />
      <span>{{ item.meta.title }}</span>
    </template>
    <v-menu v-for="subItem of item.children"
            :key="subItem.name"
            :item="subItem" />
  </el-submenu>
  <el-menu-item v-else
                :key="item.name"
                :index="item.path">
    <i v-if="item.meta.icon"
       :class="item.meta.icon" />
    <span>{{ item.meta.title }}</span>
  </el-menu-item>
</template>
<script>
export default {
  name: 'VMenu',
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}
</script>
