export default {
  search: {
    item: [
      {
        key: 'date',
        type: 'date',
        meta: {
          control_type: 'daterange',
          enableEvent: true
        }
      }
    ],
    data: () => ({
      date: []
    })
  }
}
