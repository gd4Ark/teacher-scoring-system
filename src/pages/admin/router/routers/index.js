export default [{
    path: '/index',
    component: () => import("@/pages/admin/views/scores"),
    name: 'index',
    meta: {
        title: "分数概览",
    },
    children: [],
}]