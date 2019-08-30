import { fileListToObject } from '@/common/utils/readFile'

const modulesFiles = require.context('./overview', false, /\.js$/)
const modules = fileListToObject(modulesFiles)

export default modules
