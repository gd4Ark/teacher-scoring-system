export default {
    methods: {
        /**
         * 
         * @param {*} data 
         * @returns {Array}
         */
        splitNameList(data) {
            return data.name_list
                .split("\n")
                .filter(str => str !== "")
                .map(str => {
                    return {
                        name: str.trim()
                    };
                });
        }
    }
}