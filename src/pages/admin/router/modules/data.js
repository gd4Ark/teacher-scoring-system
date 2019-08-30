import { fileListToArray } from '@/common/utils/readFile'
const routers = fileListToArray(
  require.context('./data/', false, /\.js$/),
  ['groups', 'subjects', 'teachers'].map(item => `./${item}.js`)
)
export default [
  {
    path: '/data',
    component: () => import('@/common/layouts/Home'),
    redirect: '/data/groups',
    name: 'data',
    meta: {
      title: '数据管理',
      icon: 'el-icon-ali-weibiaoti11'
    },
    children: [...routers]
  }
]
