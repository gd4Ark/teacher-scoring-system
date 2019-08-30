import isArray from 'lodash/isArray'
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
        search.forEach((item, index) => {
          if (isArray(item)) {
            const last = item[item.length - 1]
            if (last.outside) {
              data[item[0]] = item[2]
              data.where.splice(index, 1)
            }
            if (last.realKey) {
              item[0] = last.realKey
            }
          }
        })
      }
      if (order_by) {
        data.order_by = order_by
        data.desc = desc
      }
      return data
    }
  }
}
