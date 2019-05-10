export default {
    data: () => ({
        loading: false
    }),
    methods: {
        makeLoading() {
            this.loading = true
        },
        makeLoaded(timer = 10) {
            setTimeout(() => {
                this.loading = false
            }, timer)
        }
    }
}
