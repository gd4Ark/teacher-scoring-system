export default {
    install(Vue) {

        let vm = Vue.prototype;

        const o = {};

        o.random = (start, end) => {
            return Math.floor(Math.random() * (end - start) + start);
        }

        o.isString = (str) => {
            return typeof (str) === "string";
        }

        o.isUpper = (str) => {
            return /[A-Z]/.test(str);
        };

        o.isEmptyObj = (obj) => {
            return JSON.stringify(obj) === "{}";
        }

        o.clone = (obj) => (
            JSON.parse(JSON.stringify(obj))
        );

        o.isEqual = (obj1, obj2) => {
            return JSON.stringify(obj1) === JSON.stringify(obj2);
        }

        o.cover = (obj1, obj2) => {
            const a = Object.assign({}, obj1);
            const b = Object.assign({}, obj2);
            for (const key in a) {
                if (b[key] !== undefined) {
                    a[key] = b[key];
                }
            }
            return a;
        }

        o.retainKeys = (obj, keys) => {
            const newObj = {};
            keys.forEach(key => {
                newObj[key] = obj[key];
            });
            return newObj;
        }

        o.numberToW = (num) => {
            return num / 10000 + 'w';
        }

        o.firstUpperCase = (str) => (
            str.toLowerCase().replace(/( |^)[a-z]/g, (L) => L.toUpperCase())
        )

        o.msg = (() => {

            const m = {};
            const duration = 1500;

            ['success', 'warning', 'error', 'info'].forEach(el => {
                m[el] = (message) => {
                    return new Promise((resolve) => {
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
                    })
                };
            });

            return m;

        })();

        o.confirm = (({
            title = '提示',
            content = '确定吗？',
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
            })

        });

        Vue.prototype.$util = o;
    }
}