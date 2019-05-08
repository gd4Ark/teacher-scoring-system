export default [{
    path: '/overview',
    component: () => import("@/pages/admin/views/overview"),
    name: 'overview',
    meta: {
        title: "数据概览",
    }
}]