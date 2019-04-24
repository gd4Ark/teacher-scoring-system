export default [{
    path: '/teachers',
    component: () => import("@/pages/admin/views/teachers"),
    name: 'teachers',
    meta: {
        title: "教师管理",
    },
    children: [],
}]