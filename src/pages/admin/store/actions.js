import actions from "@/common/store/actions";
export default {
    async getGroup(ctx, id = null) {
        const module = 'group';
        const url = id ? module + `/${id}` : module;
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        });
    },
    async getTeacher(ctx, id = null) {
        const module = 'teacher';
        const url = id ? module + `/${id}` : module;
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        });
    },
    async getSubject(ctx, id = null) {
        const module = 'subject';
        const url = id ? module + `/${id}` : module;
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        });
    },
    async getStudent(ctx, id) {
        return console.log(ctx.store);
        const module = 'student';
        const url = id ? module + `/${id}` : module + `?group=${group}`;
        return await ctx.dispatch('get', {
            module,
            url,
            doCommit: !id,
        });
    },
    ...actions,
}