export default [{
    path: '/teacher',
    component: () => import("@/pages/admin/views/teacher"),
    name: 'teacher',
    meta: {
        title: "教师管理",
    },
    children: [],
}]