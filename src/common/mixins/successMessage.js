export default {
    methods: {
        /**
         *
         * @param {*} res
         * @returns {string}
         */
        successMessage(res) {
            const { new_count, validator_count } = res
            return `成功添加${new_count}条，失败${validator_count}条`
        }
    }
}
