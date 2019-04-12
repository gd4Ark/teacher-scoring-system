export default [{
    path: '/index',
    component: () => import("@/pages/admin/views/score"),
    name: 'index',
    meta: {
        title: "分数概览",
    },
    children: [],
}]