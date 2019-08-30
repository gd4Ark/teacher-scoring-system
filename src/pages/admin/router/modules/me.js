export default [
  {
    path: '/me',
    component: () => import('@/common/layouts/Home'),
    hidden: true,
    children: [
      {
        path: 'password',
        component: () => import('@/pages/admin/views/me/password'),
        name: 'password',
        meta: {
          title: '修改用户密码'
        }
      },
      {
        path: 'profile',
        component: () => import('@/pages/admin/views/me/profile'),
        name: 'profile',
        meta: {
          title: '修改用户信息'
        }
      }
    ]
  }
]
