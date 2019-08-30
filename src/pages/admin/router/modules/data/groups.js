// import { toRoles } from '@/common/utils/role'
export default [
  {
    path: 'groups',
    component: () => import('@/common/layouts/Layout'),
    redirect: '/data/groups/list',
    name: 'groups',
    single: true,
    meta: {
      // roles: toRoles(['admin']),
      title: '班级管理'
    },
    children: [
      {
        path: 'list',
        component: () => import('@/pages/admin/views/groups'),
        name: 'groupsList',
        hidden: true,
        meta: {
          icon: 'el-icon-ali-banji',
          title: '班级列表'
        },
        children: [
          {
            path: ':id/students',
            component: () => import('@/pages/admin/views/students'),
            name: 'studentsList',
            hidden: true,
            meta: {
              title: '学生管理',
              parent: 'group'
            },
            children: []
          },
          {
            path: ':id/teachings',
            component: () => import('@/pages/admin/views/teachings/group'),
            name: 'groupTeachings',
            hidden: true,
            meta: {
              title: '课程管理'
            },
            children: []
          }
        ]
      }
    ]
  }
]
