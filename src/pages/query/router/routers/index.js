export default [{
    path: '/scores',
    component: () => import("@/pages/query/views/scores"),
    name: 'scores',
    meta: {
        title: "分数概览",
    },
    children: [{
        path: ':sid/:tid/detail',
        component: () => import("@/pages/query/views/scores/children/detail"),
        name: 'scoresDetail',
        meta: {
            title: "分数明细",
        },
        children: [],
    }],
}]