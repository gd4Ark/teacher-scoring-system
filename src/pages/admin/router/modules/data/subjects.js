// import { toRoles } from '@/common/utils/role'
export default [
  {
    path: 'subjects',
    component: () => import('@/common/layouts/Layout'),
    redirect: '/data/subjects/list',
    name: 'subjects',
    single: true,
    meta: {
      // roles: toRoles(['admin']),
      title: '科目管理'
    },
    children: [
      {
        path: 'list',
        component: () => import('@/pages/admin/views/subjects'),
        name: 'subjectsList',
        hidden: true,
        meta: {
          icon: 'el-icon-ali-ic_subject',
          title: '科目列表'
        },
        children: [
          {
            path: ':id/teachings',
            component: () => import('@/pages/admin/views/teachings/subject'),
            name: 'subjectTeachings',
            hidden: true,
            meta: {
              title: '查看任课'
            },
            children: []
          }
        ]
      }
    ]
  }
]
