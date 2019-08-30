import loading from './loading'
import getData from './getData'
import ResponsiveSize from './ResponsiveSize'
export default {
  mixins: [ResponsiveSize, getData, loading],
  props: {
    module: {
      type: String,
      required: true
    },
    baseUrl: {
      type: String,
      default: ''
    }
  },
  data: () => ({
    loaded: false,
    multipleSelection: []
  }),
  computed: {
    state() {
      return this.$store.state[this.module]
    }
  },
  methods: {
    handleSelectionChange(val) {
      this.multipleSelection = val.map(el => el.id)
    },
    setOrder(...data) {
      this.$store.commit(`${this.module}/update`, ...data)
    },
    beforeChange() {
      this.makeLoading()
    },
    afterChange() {
      this.$nextTick(() => {
        this.$refs.table.$el.querySelector(
          '.el-table__body-wrapper'
        ).scrollTop = 0
        this.makeLoaded()
      })
    },
    async handleSortChange(val) {
      const desc = val.order === 'descending' ? 1 : 0
      const prop = val.prop || ''
      this.setOrder({
        order_by: prop,
        desc
      })
      this.beforeChange()
      await this.getData()
      this.afterChange()
    },
    renderHeader: (h, { column }) => {
      return h('i', {
        class: 'table-header-icon ' + column.label
      })
    },
    refreshTable() {
      this.$refs.table.refreshTable()
    }
  }
}
