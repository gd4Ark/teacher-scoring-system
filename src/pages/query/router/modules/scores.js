// import { toRoles } from '@/common/utils/role'
export default [
  {
    path: '/scores',
    redirect: '/scores/list',
    component: () => import('@/common/layouts/Home'),
    name: 'scores',
    single: true,
    meta: {
      // roles: toRoles(['query']),
      isIndex: true,
      title: '当前分数',
    },
    children: [
      {
        path: 'list',
        component: () => import('@/pages/query/views/scores'),
        name: 'scoresList',
        hidden: true,
        meta: {
          isIndex: true,
          icon: 'el-icon-ali-shuju',
          title: '分数列表',
        },
        children: [
          {
            path: ':sid/:tid/detail',
            component: () =>
              import('@/pages/query/views/scores/children/detail'),
            name: 'scoresDetail',
            hidden: true,
            meta: {
              title: '分数明细',
            },
            children: [],
          },
        ],
      },
    ],
  },
]
