export default [{
    path: '/subject',
    component: () => import("@/pages/admin/views/subject"),
    name: 'subject',
    meta: {
        title: "科目管理",
    },
    children: [],
}]