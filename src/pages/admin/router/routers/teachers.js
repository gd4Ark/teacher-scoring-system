export default [
    {
        path: '/teachers',
        component: () => import('@/pages/admin/views/teachers'),
        name: 'teachers',
        meta: {
            title: '教师管理'
        },
        children: [
            {
                path: ':id/teachings',
                component: () =>
                    import('@/pages/admin/views/teachings/teacher'),
                name: 'teacherTeachings',
                meta: {
                    title: '查看任课'
                },
                children: []
            }
        ]
    }
]
