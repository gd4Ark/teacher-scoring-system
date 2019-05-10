export default {
    methods: {
        beforeChange() {
            this.$emit('before-change')
        },
        afterChange() {
            this.$emit('after-change')
        }
    }
}
