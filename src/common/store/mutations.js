import { cover } from '@/common/utils'
export default {
  update: (state, data) => {
    cover(state, data, (key, val) => {
      state[key] = val
    })
  },
  currentPage(state, page) {
    state.current_page = page
  },
  sizeChange(state, size) {
    state.per_page = size
  }
}
