export default {
  methods: {
    getStatusClassName(status) {
      return [
        status ? 'yes' : 'no',
        status ? 'el-icon-ali-cc-yes-crude' : 'el-icon-ali-no'
      ]
    }
  }
}
