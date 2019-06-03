export default {
    methods: {
        /**
         *
         * @param {*} res
         * @returns {string}
         */
        successMessage(res) {
            const { new_count, fail_count } = res
            return `成功添加${new_count}条，失败${fail_count}条`
        }
    }
}
