// import { toRoles } from '@/common/utils/role'
export default [
  {
    path: 'scores',
    redirect: '/statistics/scores/list',
    component: () => import('@/common/layouts/Layout'),
    name: 'scores',
    single: true,
    meta: {
      // roles: toRoles(['admin']),
      title: '当前分数'
    },
    children: [
      {
        path: 'list',
        component: () => import('@/pages/admin/views/scores'),
        name: 'scoresList',
        hidden: true,
        meta: {
          icon: 'el-icon-ali-shuju',
          title: '分数列表'
        },
        children: [
          {
            path: ':sid/:tid/detail',
            component: () =>
              import('@/pages/admin/views/scores/children/detail'),
            name: 'scoresDetail',
            hidden: true,
            meta: {
              title: '分数明细'
            },
            children: []
          }
        ]
      }
    ]
  }
]
