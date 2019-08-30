import getters from '@/common/store/getters'
export default {
  ...getters,
  token: state => state.admin.access_token,
  me: state => state.admin.me,
  meRoles: state => state.admin.me.roleArr,
  username: state => state.admin.me.name,
  device: state => state.app.device,
  isMobile: state => state.app.device === 'mobile',
  sidebar: state => state.app.sidebar,
  root: state => state.app.root,
  navList: state => state.app.sidebar.navList,
  searchList: state => state.app.sidebar.searchList,
  showAvatar: state => state.app.showAvatar,
  title: state => state.app.title
}
