import Group from "@/pages/admin/views/group";

import Add from "@/pages/admin/views/group/children/Add";

import Student from "./group/student";
import Teaching from "./group/teaching";

export default [{
    path: '/group',
    component: Group,
    name: 'group',
    meta: {
        title: "班级管理",
    },
    children: [
        ...Student,
        ...Teaching,
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