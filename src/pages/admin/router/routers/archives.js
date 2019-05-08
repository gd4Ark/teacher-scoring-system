export default [{
    path: '/archives',
    component: () => import("@/pages/admin/views/archives"),
    name: 'archives',
    meta: {
        title: "历史归档",
    },
    children: [{
        path: ':id/detail',
        component: () => import("@/pages/admin/views/archives/children/detail"),
        name: 'archivesDetail',
        meta: {
            title: "归档明细",
        },
        children: [],
    }],
}]