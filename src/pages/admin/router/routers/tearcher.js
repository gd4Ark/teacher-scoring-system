import Tearcher from "@/pages/admin/views/tearcher";

import Add from "@/pages/admin/views/tearcher/children/Add";

export default [{
    path: '/tearcher',
    component: Tearcher,
    name: 'tearcher',
    meta: {
        title: "教师管理",
    },
    children: [
        {
            path : 'add',
            component : Add,
            name : 'addTearcher',
            meta : {
                title : "添加教师",
            }
        }
    ],
}]