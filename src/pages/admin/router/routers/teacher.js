import Teacher from "@/pages/admin/views/teacher";

import Add from "@/pages/admin/views/teacher/children/Add";

export default [{
    path: '/teacher',
    component: Teacher,
    name: 'teacher',
    meta: {
        title: "教师管理",
    },
    children: [{
        path: 'add',
        component: Add,
        name: 'addTeacher',
        meta: {
            title: "添加教师",
        }
    }],
}]