<template>
    <el-card shadow="never">
        <div v-if="needHeader"
             slot="header"
             class="card-header">
            <h2 class="card-title">{{ title }}</h2>
            <slot name="toolbar" />
        </div>
        <slot />
    </el-card>
</template>
<script>
export default {
    name: 'Card',
    props: {
        needHeader: {
            type: Boolean,
            default: true
        },
        title: {
            type: String,
            default: ''
        }
    }
}
</script>
<style lang="scss">
.el-card {
    overflow-y: auto;
    @include no-scrollbar;
}

* + .el-card {
    margin-top: $app-padding;
}
.el-card__header {
    padding: $card-header-padding;
}
.el-card__body {
    // padding: $card-body-padding;
    padding: 0;
}

.card-title {
    font-size: 1.2rem;
    font-weight: normal;
}

.card-header {
    height: $card-header-height;
    @include flex;
    align-items: center;
    justify-content: space-between;
}
</style>
