<template>
    <div class="app-footer">
        <p class="title">{{ $config.app_title }} V{{ $config.app_version }}</p>
        <p class="copyright">{{ $config.app_copyright }}</p>
    </div>
</template>
<style lang="scss" scoped>
.app-footer {
    @include footer;
}
</style>
