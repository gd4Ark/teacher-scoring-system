import Vue from 'vue'
import VueRouter from 'vue-router'

import { fileListToArray } from '@/common/utils/readFile'

import navList from './navList'

const modulesFiles = require.context('./routers', false, /\.js$/)
const routers = fileListToArray(modulesFiles)

const routerConfig = {
    // mode: process.env.NODE_ENV === 'development' ? 'history' : 'hash',
    base: '/query',
    mode: 'history',
    navList,
    routes: [
        {
            path: '/',
            redirect: '/index'
        },
        {
            path: '/index',
            redirect: '/scores'
        },
        {
            path: '/',
            component: () => import('@/common/layouts/Home'),
            children: [
                ...routers,
                {
                    path: '/404',
                    component: () => import('@/common/layouts/404'),
                    meta: {
                        title: '404'
                    }
                }
            ]
        },
        {
            path: '*',
            redirect: '404'
        }
    ]
}

Vue.use(VueRouter)

const router = new VueRouter(routerConfig)

router.beforeEach(async(to, from, next) => {
    if (to.meta.title) {
        document.title = to.meta.title
    }
    return next()
})

export default router
