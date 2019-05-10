<template>
    <router-view v-if="isSubRouter" />
    <div v-else
         class="inner-container">
        <slot />
    </div>
</template>
<script>
export default {
    name: 'NotSubRouter',
    props: {
        name: {
            type: String,
            required: true
        }
    },
    computed: {
        isSubRouter() {
            return this.$route.name !== this.name
        }
    }
}
</script>
