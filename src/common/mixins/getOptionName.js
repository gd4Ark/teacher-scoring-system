import { mapActions } from 'vuex'
const byOptionName = (id, module, isOptions) => {
  const options = isOptions ? module : module.options
  const item = options.find(el => el.value === id)
  return item ? item.label : ''
}
export default {
  filters: {
    byOptionName
  },
  methods: {
    ...mapActions(['getOptions']),
    async getAllOptions(modules) {
      return await this.getOptions(modules)
    },
    byOptionName
  }
}
