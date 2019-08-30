import router from './index'

import NProgress from 'nprogress' // progress bar
import 'nprogress/nprogress.css' // progress bar style

import getPageTitle from '@/common/utils/get-page-title'
// import { hasPermission, findRoleHome } from '@/common/utils/role'

const whiteList = ['/login'] // no redirect whitelist

router.beforeEach(async (to, from, next) => {
  // start progress bar
  NProgress.start()
  // set page title
  document.title = getPageTitle(to.meta.title)
  if (whiteList.indexOf(to.path) !== -1) {
    return next()
  }

  // const store = router.app.$options.store
  // const user = store.state.admin
  // const roles = user.me.roleArr
  // if (!user || !user.access_token) {
  //     return next(`/login?redirect=${to.path}`)
  // }
  // if (!hasPermission(roles, to)) {
  //     return next(`/error/401?redirect=${from.path}`)
  // }
  // if (to.path === '/roleHome') {
  //     return next(findRoleHome(roles))
  // }

  return next()
})

router.afterEach(() => {
  // finish progress bar
  NProgress.done()
})
