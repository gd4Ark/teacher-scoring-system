import axios from "axios"
import qs from "qs"
import {
    log
} from "./index"
import {
    error
} from "./message"

export default {
    install(Vue, {
        router,
        store,
        baseURL,
        needAuth = false,
    }) {

        axios.defaults.baseURL = baseURL

        // request interceptor
        axios.interceptors.request.use(
            config => {
                // Add Token
                if (needAuth) {
                    const user = store.state.user
                    if (user && user.access_token) {
                        const token = user.access_token
                        const stringifyStatus = ["get", "delete"].includes(
                            config.method
                        )
                        let data = config[stringifyStatus ? "params" : "data"]
                        switch (true) {
                            // FormData
                            case data instanceof FormData:
                                data.append("token", token)
                                break
                                // Params
                            case stringifyStatus:
                                data.token = token
                                break
                                // Data
                            default:
                                data = qs.parse(data)
                                data.token = token
                                data = qs.stringify(data)
                                break
                        }
                        config[stringifyStatus ? "params" : "data"] = data
                    }
                }
                return config
            },
            error => {
                error("timed out!")
                return Promise.reject(error)
            }
        )

        // response interceptor
        axios.interceptors.response.use(
            data => {
                return data.data.data || data.data
            },
            err => {
                if (!err.response) {
                    error(err)
                    return Promise.reject(err)
                }
                const status = err.response.status
                const message = err.response.data.msg
                if (process.env.NODE_ENV === "development") {
                    log("error: " + message)
                }
                if (status === 401) {
                    error(message).then(() => {
                        router.push("/login")
                    })
                } else {
                    error(message || "an error occurred!")
                }
                return Promise.reject(err)
            }
        )

        // request methods

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
            })
        }

        /**
         *
         * @param {*} url
         * @param {*} data
         */
        const post = (url, data = {}) => {
            data = qs.stringify(data)
            return axios({
                method: "post",
                url,
                data
            })
        }

        /**
         *
         * @param {*} url
         * @param {*} data
         */
        const put = (url, data = {}) => {
            data = qs.stringify(data)
            return axios({
                method: "put",
                url,
                data
            })
        }

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
            })
        }

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
            })
        }

        /**
         * all methods
         */
        const methods = {
            get,
            post,
            put,
            delete: del,
            upload
        }

        /**
         * package function
         */
        const ax = {}

        Object.keys(methods).forEach(key => {
            ax[key] = methods[key]
        })

        Vue.prototype.$axios = ax
    }
}