import Subject from "@/pages/admin/views/subject";

import Add from "@/pages/admin/views/subject/children/Add";

export default [{
    path: '/subject',
    component: Subject,
    name: 'subject',
    meta: {
        title: "科目管理",
    },
    children: [{
        path: 'add',
        component: Add,
        name : 'addSubject',
        meta: {
            title: "添加科目",
        }
    }],
}]