import Teaching from "@/pages/admin/views/group/childrens/teaching";

export default [{
    path: ':group_id/teaching',
    component: Teaching,
    name: 'teaching',
    meta: {
        title: "课程管理",
    },
    children: [],
}]