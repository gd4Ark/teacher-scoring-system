import Teaching from "@/pages/admin/views/teaching";

import Add from "@/pages/admin/views/teaching/children/Add";

export default [{
    path: ':group/teaching',
    component: Teaching,
    name: 'teaching',
    meta: {
        title: "课程管理",
    },
    children: [{
        path: 'add',
        component: Add,
        name: 'addTeaching',
        meta: {
            title: "添加课程",
        }
    }],
}]