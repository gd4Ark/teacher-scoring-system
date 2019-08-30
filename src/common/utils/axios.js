import axios from 'axios'
import qs from 'qs'
import { log } from './index'
import { error } from './message'

export default {
  install(Vue, { router, store, baseURL, needAuth = false }) {
    axios.defaults.baseURL = baseURL

    // request interceptor
    axios.interceptors.request.use(
      config => {
        config.headers = {
          ...config.headers,
          ...getHeader(),
        }
        return config
      },
      error => {
        error('timed out!')
        return Promise.reject(error)
      },
    )

    // response interceptor
    axios.interceptors.response.use(
      response => {
        const { authorization } = response.headers
        if (authorization) {
          store.commit('auth_user/updateToken', authorization)
        }
        return response.data.data !== undefined
          ? response.data.data
          : response.data
      },
      err => {
        if (!err.response) {
          error(err)
          return Promise.reject(err)
        }
        const status = err.response.status
        const message = err.response.data.message
        if (process.env.NODE_ENV === 'development') {
          log('error: ' + message)
        }
        if (status === 401) {
          error(message)
          router.push('/login')
        } else {
          error(message || '发生错误，请刷新重试！')
        }
        return Promise.reject(err)
      },
    )

    const getHeader = () => {
      return needAuth
        ? {
          Authorization: `Bearer ${store.getters.token}`,
        }
        : {}
    }

    // request methods

    /**
     *
     * @param {*} url
     * @param {*} data
     */
    const get = (url, data = {}) => {
      return axios({
        method: 'get',
        url,
        params: data,
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
        method: 'post',
        url,
        data,
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
        method: 'put',
        url,
        data,
      })
    }

    /**
     *
     * @param {*} url
     * @param {*} data
     */
    const del = (url, data = {}) => {
      return axios({
        method: 'delete',
        url,
        params: data,
      })
    }

    /**
     *
     * @param {*} url
     * @param {*} data
     */
    const upload = (url, data = {}) => {
      return axios({
        method: 'post',
        url,
        data,
        headers: {
          'Content-Type': 'multipart/form-data',
        },
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
      upload,
    }

    /**
     * package function
     */
    const ax = {}

    Object.keys(methods).forEach(key => {
      ax[key] = methods[key]
    })

    Vue.prototype.$axios = ax
  },
}
