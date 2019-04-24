export default [{
    path: '/subjects',
    component: () => import("@/pages/admin/views/subjects"),
    name: 'subjects',
    meta: {
        title: "科目管理",
    },
    children: [],
}]