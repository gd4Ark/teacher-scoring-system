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

const sortKey = (keys, sorts) => {
  const set = new Set([...sorts, ...keys])
  return [...set]
}

/**
 *
 *
 * @export
 * @param {*} modulesFiles
 * @param {*} sorts = null
 * @returns {Array}
 */
export function fileListToArray(modulesFiles, sorts = null) {
  let keys = modulesFiles.keys()
  if (sorts) {
    keys = sortKey(keys, sorts)
  }
  return keys.map(modulePath => {
    const value = modulesFiles(modulePath)
    return value.default[0]
  }, {})
}
