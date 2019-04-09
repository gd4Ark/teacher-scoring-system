import axios from "axios";
import qs from "qs";

export default {
    /**
     * 
     * @param {*} Vue 
     * @param {*} options 
     */
    install(Vue, options) {
        let vm = Vue.prototype;

        let config = vm.$config;

        let router = options.router;

        let store = options.store;

        const useToekn = options.useToekn;

        axios.defaults.baseURL = config.server_url;

        // 请求拦截器

        axios.interceptors.request.use(
            config => {
                // Add Token
                if (useToekn) {
                    const login = store.state.login;
                    if (login && login.access_token) {
                        const token = login.access_token;
                        const stringifyStatus = ["get", "delete"].includes(
                            config.method
                        );
                        let data = config[stringifyStatus ? "params" : "data"];
                        switch (true) {
                            // FormData
                            case data instanceof FormData:
                                data.append("token", token);
                                break;
                                // Params
                            case stringifyStatus:
                                data.token = token;
                                break;
                                // Data
                            default:
                                data = qs.parse(data);
                                data.token = token;
                                data = qs.stringify(data);
                                break;
                        }
                        config[stringifyStatus ? "params" : "data"] = data;
                    }
                }
                return config;
            },
            err => {
                vm.$util.msg.error("请求超时!");
                return Promise.reject(err);
            }
        );

        // 响应拦截器
        axios.interceptors.response.use(
            data => {
                return data.data.data || data.data;
            },
            err => {
                const status = err.response.status;
                const message = err.response.data.msg;
                if (process.env.NODE_ENV === 'development') {
                    console.error(message);
                }
                if (status === 401) {
                    vm.$util.msg.error(message).then(() => {
                        router.push("/login");
                    });
                } else {
                    vm.$util.msg.error(message || "发生错误！");
                }
                return Promise.reject(err);
            }
        );

        // 请求方法

        /**
         * 
         * @param {*} url 
         * @param {*} data 
         */
        const get = (url, data = {}) => {
            return axios({
                method: "get",
                url,
                params: data
            });
        };

        /**
         * 
         * @param {*} url 
         * @param {*} data 
         */
        const post = (url, data = {}) => {
            data = qs.stringify(data);
            return axios({
                method: "post",
                url,
                data
            });
        };

        /**
         * 
         * @param {*} url 
         * @param {*} data 
         */
        const put = (url, data = {}) => {
            data = qs.stringify(data);
            return axios({
                method: "put",
                url,
                data
            });
        };

        /**
         * 
         * @param {*} url 
         * @param {*} data 
         */
        const del = (url, data = {}) => {
            return axios({
                method: "delete",
                url,
                params: data
            });
        };

        /**
         * 
         * @param {*} url 
         * @param {*} data 
         */
        const upload = (url, data = {}) => {
            return axios({
                method: "post",
                url,
                data,
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            });
        };

        /**
         * 所有方法
         */
        const methods = {
            get,
            post,
            put,
            delete: del,
            upload
        };

        /**
         * 封装函数
         */
        const ax = {};

        Object.keys(methods).forEach(key => {
            ax[key] = methods[key];
        });

        Vue.prototype.$axios = ax;
    }
};