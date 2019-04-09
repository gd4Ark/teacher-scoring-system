export default {

    search: {
        item: [{
            label: "姓名",
            key: "name",
            type: "text",
            operation: 'like',
        }],
        data: () => ({
            name: '',
        })
    }

}