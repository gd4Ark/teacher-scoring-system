import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI);

import App from '@/common/App'

import config from "@/common/config/config";
Vue.use(config);

import router from './router/index';

import store from './store/index'

import util from "@/common/utils/util";
Vue.use(util);

import vData from "@/common/data/index";

Vue.use(vData);

import axios from "@/common/utils/axios";

Vue.use(axios, {
  router,
  store,
  useToekn: true,
});

import vCard from "@/common/components/Card";
Vue.component('vCard', vCard);

import cForm from "@/common/components/Form";
Vue.component('cForm', cForm);

import NotSubRouter from "@/common/components/NotSubRouter";
Vue.component('NotSubRouter', NotSubRouter);

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
  store,
}).$mount('#app')