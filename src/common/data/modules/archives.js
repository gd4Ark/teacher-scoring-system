export default {

    search: {
        item: [{
            label: "归档名称",
            key: "name",
            type: "text",
            operation: '=',
        }, ],
        data: () => ({
            name: '',
        })
    }

}