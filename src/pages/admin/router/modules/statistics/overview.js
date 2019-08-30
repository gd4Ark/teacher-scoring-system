// import { toRoles } from '@/common/utils/role'
export default [
  {
    path: 'overview',
    component: () => import('@/common/layouts/Layout'),
    redirect: '/statistics/overview/index',
    single: true,
    children: [
      {
        path: 'index',
        component: () => import('@/pages/admin/views/overview'),
        hidden: true,
        name: 'overview',
        meta: {
          isIndex: true,
          title: '数据概览',
          icon: 'el-icon-ali-caigouleixingzhanbi'
        }
      }
    ]
  }
]
