export default {
    data: () => ({
        load: false,
    }),
    methods: {
        loaded(timer = 40) {
            setTimeout(() => {
                this.load = true
            }, timer);
        },
    }
}