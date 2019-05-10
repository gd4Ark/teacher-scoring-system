/**
 *
 *
 * @export
 * @param {*} modulesFiles
 * @returns {Object}
 */
export function fileListToObject(modulesFiles) {
    return modulesFiles.keys().reduce((modules, modulePath) => {
        // set './app.js' => 'app'
        const moduleName = modulePath.replace(/^\.\/(.*)\.\w+$/, '$1')
        const value = modulesFiles(modulePath)
        modules[moduleName] = value.default
        return modules
    }, {})
}

/**
 *
 *
 * @export
 * @param {*} modulesFiles
 * @returns {Array}
 */
export function fileListToArray(modulesFiles) {
    return modulesFiles.keys().map(modulePath => {
        const value = modulesFiles(modulePath)
        return value.default[0]
    }, {})
}
