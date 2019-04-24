export default [{
    path: ':group_id/teachings',
    component: () => import("@/pages/admin/views/groups/childrens/teachings"),
    name: 'teachings',
    meta: {
        title: "课程管理",
    },
    children: [],
}]