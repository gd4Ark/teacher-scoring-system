<template>
  <div class="app-footer">
    <p class="app-footer__title">{{ $config.app_title }} V{{ $config.app_version }}</p>
    <p class="app-footer__copyright">{{ $config.app_copyright }}</p>
  </div>
</template>
<style lang="scss" scoped>
.app-footer {
  @include wh(100%, 30px);
  @include flex;
  align-items: center;
  justify-content: space-between;
  color: rgb(102, 102, 102);
  opacity: 0.5;
}
.app-footer__title {
  font-size: 0.8rem;
}
.app-footer__copyright {
  font-size: 0.7rem;
}
</style>
