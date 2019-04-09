export default {
    methods: {
        /**
         * 
         * @param {*} res 
         * @returns {string}
         */
        successMessage(res) {
            const {
                create_count,
                new_count
            } = res;
            return `本次添加${create_count}条，新增${new_count}条`;
        }
    }
}