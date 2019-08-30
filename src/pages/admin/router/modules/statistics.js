import { fileListToArray } from '@/common/utils/readFile'
const routers = fileListToArray(
  require.context('./statistics/', false, /\.js$/),
  ['overview', 'scores', 'archives'].map(item => `./${item}.js`)
)
export default [
  {
    path: '/statistics',
    component: () => import('@/common/layouts/Home'),
    redirect: '/statistics/overview',
    meta: {
      title: '分数统计',
      icon: 'el-icon-ali-tongji'
    },
    children: [...routers]
  }
]
