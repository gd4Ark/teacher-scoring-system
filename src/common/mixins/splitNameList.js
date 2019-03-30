export default {
    methods: {
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