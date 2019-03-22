import Course from "@/pages/admin/views/course";

import Add from "@/pages/admin/views/course/children/Add";

export default [{
    path: ':id/course',
    component: Course,
    name: 'course',
    meta: {
        title: "课程管理",
    },
    children: [{
        path: 'add',
        component: Add,
        name : 'addCourse',
        meta: {
            title: "添加课程",
        }
    }],
}]