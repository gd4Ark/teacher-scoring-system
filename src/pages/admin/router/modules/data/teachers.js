// import { toRoles } from '@/common/utils/role'
export default [
  {
    path: 'teachers',
    component: () => import('@/common/layouts/Layout'),
    redirect: '/data/teachers/list',
    name: 'teachers',
    single: true,
    meta: {
      // roles: toRoles(['admin']),
      title: '教师管理'
    },
    children: [
      {
        path: 'list',
        component: () => import('@/pages/admin/views/teachers'),
        name: 'teachersList',
        hidden: true,
        meta: {
          icon: 'el-icon-ali-jiaoshi',
          title: '教师列表'
        },
        children: [
          {
            path: ':id/teachings',
            component: () => import('@/pages/admin/views/teachings/teacher'),
            name: 'teacherTeachings',
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
