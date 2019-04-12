export default [{
    path: ':group_id/teaching',
    component: () => import("@/pages/admin/views/group/childrens/teaching"),
    name: 'teaching',
    meta: {
        title: "课程管理",
    },
    children: [],
}]