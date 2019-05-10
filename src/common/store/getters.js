export default {
    requestData() {
        return origin => {
            const {
                current_page,
                per_page,
                search_keyword,
                order_by,
                desc
            } = origin
            const data = {
                page: current_page,
                per_page
            }
            if (search_keyword.length) {
                data.where = search_keyword
            }
            if (order_by) {
                data.order_by = order_by
                data.desc = desc
            }
            return data
        }
    }
}
