export default {
    requestData() {
        return origin => {
            const { current_page, per_page, search, order_by, desc } = origin
            const data = {
                page: current_page,
                per_page
            }
            if (search.length) {
                data.where = search
            }
            if (order_by) {
                data.order_by = order_by
                data.desc = desc
            }
            return data
        }
    }
}
