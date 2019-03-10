import Vue from 'vue'
import VueRouter from 'vue-router';

import notFound from "@/common/layouts/404";

import navList from "./navList";

import Home from "@/common/layouts/Home";

import Score from "./routers/score";
import Group from "./routers/group";
import Tearcher from "./routers/tearcher";

import Login from "../views/Login";

const routerConfig = {
    mode: process.env.NODE_ENV == 'development' ? 'history' : 'hash',
    navList,
    routes: [{
            path: '/',
            redirect: '/score',
        },
        {
            path: '/index',
            redirect: "/flow",
        },
        {
            path: '/',
            component: Home,
            children: [
                ...Score,
                ...Group,
                ...Tearcher,
                {
                    path: '/404',
                    component: notFound,
                    meta: {
                        title: '404',
                    }
                },
            ]
        },
        {
            path: '/login',
            component: Login,
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