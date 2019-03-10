<template>
  <div class="app-footer">
    <p class="copyright">{{ $config.app_copyright }}</p>
    <p class="title">{{ $config.app_title }} V{{ $config.app_version }}</p>
  </div>
</template>
<style lang="scss" scoped>
.app-footer {
  @include footer;
}
</style>