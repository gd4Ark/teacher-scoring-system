import {
    fileListToArray
} from "@/common/utils/readFile";

const modulesFiles = require.context('./group', false, /\.js$/)
const routers = fileListToArray(modulesFiles);

export default [{
    path: '/group',
    component: () => import("@/pages/admin/views/group"),
    name: 'group',
    meta: {
        title: "班级管理",
    },
    children: [
        ...routers,
    ],
}]