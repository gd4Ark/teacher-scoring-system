export default [
    {
        path: '/groups',
        component: () => import('@/pages/admin/views/groups'),
        name: 'groups',
        meta: {
            title: '班级管理'
        },
        children: [
            {
                path: ':id/students',
                component: () => import('@/pages/admin/views/students'),
                name: 'students',
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
                meta: {
                    title: '课程管理'
                },
                children: []
            }
        ]
    }
]
