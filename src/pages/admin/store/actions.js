import actions from "@/common/store/actions";
export default {
    async getGroup(ctx, id = null) {
        const module = 'group';
        let url = module + 's';
        url = id ? url + `/${id}` : url;
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        });
    },
    async getTeacher(ctx, id = null) {
        const module = 'teacher';
        let url = module + 's';
        url = id ? url + `/${id}` : url;
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        });
    },
    async getSubject(ctx, id = null) {
        const module = 'subject';
        let url = module + 's';
        url = id ? url + `/${id}` : url;
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        });
    },
    async getStudent(ctx, id) {
        const {
            group_id
        } = ctx.state.student;
        const module = 'student';
        let url = module + 's';
        url = id ? url + `/${id}` : url + `?groupId=${group_id}`;
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        });
    },
    ...actions,
}