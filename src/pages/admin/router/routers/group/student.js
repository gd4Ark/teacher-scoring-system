import Student from "@/pages/admin/views/group/childrens/student";

export default [{
    path: ':group_id/student',
    component: Student,
    name: 'student',
    meta: {
        title: "学生管理",
    },
    children: [],
}]