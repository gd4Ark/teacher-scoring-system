export default {
    methods: {
        beforeAddSubmit(data) {
            data.names = data.names
                .split('\n')
                .map(s => s.trim())
                .filter(s => s)
                .join('\n')
            return data
        },
        beforeEditSubmit(data) {
            data.name = data.name.trim()
            return data
        }
    }
}
