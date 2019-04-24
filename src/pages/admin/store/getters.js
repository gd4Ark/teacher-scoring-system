import getters from "@/common/store/getters"
export default {
    ...getters,
    token: state => state.user.access_token,
    username: state => state.user.username,
    device: state => state.app.device,
    isMobile : state => state.app.device === 'mobile',
    sidebar: state => state.app.sidebar,
}