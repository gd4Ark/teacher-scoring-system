export default [
  {
    path: '/error',
    component: () => import('@/common/layouts/Home'),
    hidden: true,
    children: [
      {
        path: '401',
        component: () => import('@/common/layouts/401'),
        hidden: true,
        meta: {
          title: '401'
        }
      },
      {
        path: '404',
        component: () => import('@/common/layouts/404'),
        hidden: true,
        meta: {
          title: '404'
        }
      }
    ]
  }
]
