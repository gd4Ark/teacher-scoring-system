import {
    fileListToArray
} from "@/common/utils/readFile";

const modulesFiles = require.context('./groups', false, /\.js$/)
const routers = fileListToArray(modulesFiles);

export default [{
    path: '/groups',
    component: () => import("@/pages/admin/views/groups"),
    name: 'groups',
    meta: {
        title: "班级管理",
    },
    children: [
        ...routers,
    ],
}]