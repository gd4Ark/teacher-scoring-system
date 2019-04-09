import Group from "@/pages/admin/views/group";

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
    ],
}]