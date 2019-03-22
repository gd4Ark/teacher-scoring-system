export default {
    requestData() {
        return (origin) => {
            const {
                current_page,
                pre_page,
                search_keyword,
            } = origin;
            const data = {
                page: current_page,
                pre_page,
            };
            if (search_keyword.length) {
                data.where = search_keyword;
            }
            return data;
        }
    },
}