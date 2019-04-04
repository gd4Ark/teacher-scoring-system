import Student from "@/pages/admin/views/student";

import Add from "@/pages/admin/views/student/children/Add";

export default [{
    path: ':group_id/student',
    component: Student,
    name: 'student',
    meta: {
        title: "学生管理",
    },
    children: [{
        path: 'add',
        name : 'addStudent',
        component: Add,
        meta: {
            title: "添加学生",
        }
    }],
}]