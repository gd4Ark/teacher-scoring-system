<template>
  <div id="app">
    <router-view />
  </div>
</template>
<script>
import ResizeHandler from '@/common/mixins/ResizeHandler.js'
import { mapGetters } from 'vuex'
export default {
    mixins: [ResizeHandler],
    computed: {
        ...mapGetters(['device'])
    },
    watch: {
        device() {
            this.setHTMLClass()
        }
    },
    mounted() {
        this.setHTMLClass()
    },
    methods: {
        setHTMLClass() {
            document.querySelector('html').className = this.device
        }
    }
}
</script>

<style lang="scss">
@import '@/common/styles/_reset.scss';
</style>
