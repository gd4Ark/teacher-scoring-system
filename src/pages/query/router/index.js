import Vue from 'vue'
import VueRouter from 'vue-router'

const routerPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return routerPush.call(this, location).catch(error => error)
}

import { fileListToArray } from '@/common/utils/readFile'

import navSort from './navSort'

const routers = fileListToArray(
  require.context('./modules/', false, /\.js$/),
  navSort,
)
const routerConfig = {
  // mode: process.env.NODE_ENV === 'development' ? 'history' : 'hash',
  mode: 'history',
  routes: [
    {
      path: '/',
      redirect: '/index',
      hidden: true,
    },
    {
      path: '/index',
      // redirect: '/roleHome',
      redirect: '/scores',
      hidden: true,
    },
    ...routers,
    {
      path: '*',
      redirect: '/error/404',
      hidden: true,
    },
  ],
}

Vue.use(VueRouter)

const router = new VueRouter(routerConfig)

export default router
