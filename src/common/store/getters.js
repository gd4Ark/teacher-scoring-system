export default {
    requestData(state) {
        return (origin) => {
            const {
                pageIndex,
                pageSize,
                searchKeyword,
            } = origin;
            const data = {
                pageIndex,
                pageSize,
            };
            if (searchKeyword.length) {
                data.searchKeyword = searchKeyword;
            }
            return data;
        }
    },
}