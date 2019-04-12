export default [{
    path: ':group_id/student',
    component: () => import("@/pages/admin/views/group/childrens/student"),
    name: 'student',
    meta: {
        title: "学生管理",
    },
    children: [],
}]