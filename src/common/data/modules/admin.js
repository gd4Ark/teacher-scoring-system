import { fileListToObject } from '@/common/utils/readFile'

const modulesFiles = require.context('./admin/', false, /\.js$/)
const modules = fileListToObject(modulesFiles)

export default modules
