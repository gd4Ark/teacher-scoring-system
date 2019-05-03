export default [{
    path: '/subjects',
    component: () => import("@/pages/admin/views/subjects"),
    name: 'subjects',
    meta: {
        title: "科目管理",
    },
    children: [{
        path: ':id/teachings',
        component: () => import("@/pages/admin/views/teachings/subject"),
        name: 'subjectTeachings',
        meta: {
            title: "查看任课",
        },
        children: [],
    }],
}]