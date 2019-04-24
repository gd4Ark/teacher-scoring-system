var store = (function () {

    var get = (key) => {
        return JSON.parse(localStorage.getItem(key)) || null
    }

    var set = (key, data) => {
        localStorage.setItem(key, JSON.stringify(data))
    }

    var has = function (key) {
        return get(key) !== null
    }

    var del = function (key) {
        localStorage.removeItem(key)
    }

    return {
        set: set,
        get: get,
        has: has,
        del: del,
    }

})()