import Vue from 'vue'
import VueRouter from 'vue-router';

import {
    fileListToArray
} from "@/common/utils/readFile";

import navList from "./navList";

const modulesFiles = require.context('./routers', false, /\.js$/)
const routers = fileListToArray(modulesFiles);

const routerConfig = {
    mode: process.env.NODE_ENV == 'development' ? 'history' : 'hash',
    navList,
    routes: [{
            path: '/',
            redirect: '/index',
        },
        {
            path: '/',
            component: () => import("@/common/layouts/Home"),
            children: [
                ...routers,
                {
                    path: '/password',
                    component: () => import("../views/password"),
                    name: 'password',
                    meta: {
                        title: "修改密码",
                    },
                },
                {
                    path: '/404',
                    component: () => import("@/common/layouts/404"),
                    meta: {
                        title: '404',
                    }
                },
            ]
        },
        {
            path: '/login',
            component: () => import("../views/login"),
            meta: {
                title: '登录',
            }
        },
        {
            path: '*',
            redirect: '404',
        }
    ]
}

Vue.use(VueRouter);

const router = new VueRouter(
    routerConfig,
);

router.beforeEach(async (to, from, next) => {
    if (to.meta.title) {
        document.title = to.meta.title;
    }
    next();
    return;
    // if (to.path === '/login') {
    //     next();
    //     return;
    // }
    // const store = router.app.$options.store;
    // const login = store.state.login;
    // if (login && login.token) {
    //     await store.dispatch('checkLogin')
    //     next();
    // } else {
    //     next({
    //         path: '/login',
    //     });
    // }
});

export default router;