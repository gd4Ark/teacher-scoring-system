export default {
    currentPage(state, page) {
        state.current_page = page
    },
    sizeChange(state, size) {
        state.per_page = size
    }
}