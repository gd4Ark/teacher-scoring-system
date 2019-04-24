export default [{
    path: ':group_id/students',
    component: () => import("@/pages/admin/views/groups/childrens/students"),
    name: 'students',
    meta: {
        title: "学生管理",
    },
    children: [],
}]