export default {
    install(Vue) {
        let vm = Vue.prototype;

        const o = {};

        /**
         *
         * @param start
         * @param end
         */
        o.random = (start, end) => {
            return Math.floor(Math.random() * (end - start) + start);
        };

        /**
         *
         * @param str
         */
        o.isString = str => {
            return typeof str === "string";
        };

        /**
         *
         * @param str
         */
        o.isUpper = str => {
            return /[A-Z]/.test(str);
        };

        /**
         *
         * @param obj
         * @returns {boolean}
         */
        o.isEmptyObj = obj => {
            return JSON.stringify(obj) === "{}";
        };

        /**
         *
         * @param obj
         * @returns {any}
         */
        o.clone = obj => JSON.parse(JSON.stringify(obj));

        o.isEqual = (obj1, obj2) => {
            return JSON.stringify(obj1) === JSON.stringify(obj2);
        };

        /**
         *
         * @param obj1
         * @param obj2
         * @returns {any}
         */
        o.cover = (obj1, obj2) => {
            const a = Object.assign({}, obj1);
            const b = Object.assign({}, obj2);
            for (const key in a) {
                if (b[key] !== undefined) {
                    a[key] = b[key];
                }
            }
            return a;
        };

        /**
         *
         * @param obj
         * @param keys
         * @return Object
         */
        o.retainKeys = (obj, keys) => {
            const newObj = {};
            keys.forEach(key => {
                newObj[key] = obj[key];
            });
            return newObj;
        };

        /**
         *
         * @param num
         * @return {string}
         */
        o.numberToW = num => {
            return num / 10000 + "w";
        };

        /**
         * 
         * @param str
         * @return {string}
         */
        o.firstUpperCase = str =>
            str.toLowerCase().replace(/( |^)[a-z]/g, L => L.toUpperCase());

        o.msg = (() => {
            const m = {};
            const duration = 1500;

            ["success", "warning", "error", "info"].forEach(el => {
                m[el] = message => {
                    return new Promise(resolve => {
                        vm.$message({
                            message,
                            type: el,
                            duration,
                            center: true,
                            showClose: true,
                            onClose: () => {
                                resolve();
                            }
                        });
                    });
                };
            });

            return m;
        })();

        /**
         *
         * @param title
         * @param content
         * @return {Promise<any>}
         */
        o.confirm = ({
            title = "提示",
            content = "确定吗？"
        }) => {
            return new Promise((resolve, reject) => {
                vm.$confirm(content, title, {
                        confirmButtonText: "确定",
                        cancelButtonText: "取消",
                        type: "warning"
                    })
                    .then(() => {
                        resolve();
                    })
                    .catch(() => {
                        reject();
                    });
            });
        };

        Vue.prototype.$util = o;
    }
};