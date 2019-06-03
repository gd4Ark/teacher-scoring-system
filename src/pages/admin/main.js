import Vue from 'vue'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)

import '@/static/iconfont/iconfont.css'

import config from '@/common/config'
Vue.prototype.$config = config

import data from '@/common/data/index'
Vue.prototype.$v_data = data

import App from '@/common/App'
import router from './router/index'
import store from './store/index'

const baseURL = config.is_prod ? config.server_url : config.dev_server_url

import axios from '@/common/utils/axios'
Vue.use(axios, {
    router,
    store,
    baseURL,
    needAuth: true
})

import vCard from '@/common/components/Card'
Vue.component('vCard', vCard)

import NotSubRouter from '@/common/components/NotSubRouter'
Vue.component('NotSubRouter', NotSubRouter)

Vue.config.productionTip = false

new Vue({
    render: h => h(App),
    router,
    store
}).$mount('#app')
