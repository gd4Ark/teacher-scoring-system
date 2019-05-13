export default [
    {
        path: '/scores',
        component: () => import('@/pages/query/views/scores'),
        name: 'scores',
        meta: {
            title: '分数概览'
        },
        children: []
    }
]
