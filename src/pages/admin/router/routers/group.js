import Group from "@/pages/admin/views/group";

import Add from "@/pages/admin/views/group/children/Add";
import AddStudent from "@/pages/admin/views/group/children/AddStudent";

export default [{
    path: '/group',
    component: Group,
    name: 'group',
    meta: {
        title: "班级管理",
    },
    children: [{
            path: 'add',
            component: Add,
            meta: {
                title: "添加班级",
            }
        },
        {
            path: 'addStudent',
            component: AddStudent,
            meta: {
                title: "添加学生",
            }
        }
    ],
}]