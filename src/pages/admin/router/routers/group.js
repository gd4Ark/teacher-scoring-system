import Group from "@/pages/admin/views/group";

import Add from "@/pages/admin/views/group/children/Add";

import Student from "./group/student";
import Course from "./group/course";

export default [{
    path: '/group',
    component: Group,
    name: 'group',
    meta: {
        title: "班级管理",
    },
    children: [
        ...Student,
        ...Course,
        {
            path: 'add',
            component: Add,
            name : 'addGroup',
            meta: {
                title: "添加班级",
            }
        },
    ],
}]