// import { toRoles } from '@/common/utils/role'
export default [
  {
    path: 'archives',
    component: () => import('@/common/layouts/Layout'),
    redirect: '/statistics/archives/list',
    name: 'archives',
    single: true,
    meta: {
      // roles: toRoles(['admin']),
      title: '归档管理'
    },
    children: [
      {
        path: 'list',
        component: () => import('@/pages/admin/views/archives'),
        name: 'archivesList',
        hidden: true,
        meta: {
          icon: 'el-icon-ali-archives',
          title: '归档列表'
        },
        children: [
          {
            path: ':id/detail',
            component: () =>
              import('@/pages/admin/views/archives/children/detail'),
            name: 'archivesDetail',
            hidden: true,
            meta: {
              title: '归档明细'
            },
            children: []
          }
        ]
      }
    ]
  }
]
