<template>
  <v-card :title="title"
          class="search">
    <div slot="toolbar"
         class="toolbar">
      <el-button :size="respBtnSize"
                 type="primary"
                 @click="submit">
        搜索
      </el-button>
      <el-button :size="respBtnSize"
                 type="info"
                 @click="handleReset">
        重置
      </el-button>
    </div>
    <v-form :inline="true"
            :form-item="formItem"
            :form-data="formData"
            @submit="submit" />
  </v-card>
</template>
<script>
import { mapActions } from 'vuex'
import getData from '@/common/mixins/getData'
import submitChange from '@/common/mixins/submitChange'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
  name: 'BaseSearch',
  mixins: [ResponsiveSize, getData, submitChange],
  props: {
    title: {
      type: String,
      default: '搜索'
    },
    module: {
      type: String,
      required: true
    }
  },
  data: () => ({
    search: []
  }),
  computed: {
    submitAction() {
      return `${this.module}search`
    },
    formItem() {
      return this.$v_data[this.module].search.item
    },
    formData() {
      const state = this.$store.state[this.module]
      if (this._.isEmpty(state.search_data)) {
        state.search_data = this.$v_data[this.module].search.data()
      }
      return state.search_data
    }
  },
  methods: {
    ...mapActions(['resetSearchData', 'updateSearch']),
    reset() {
      this.resetSearchData(this.module)
    },
    handleReset() {
      this.reset()
      this.submit()
    },
    submit() {
      this.search = []
      this.initSearchData(this.formItem)
      this.handleSubmit()
    },
    initSearchData(array, key = '') {
      array.forEach(el => {
        if (el.isObject) {
          return this.search.push({
            type: el.type,
            key: el.key,
            data: this.formData[el.key]
          })
        } else if (el.items) {
          return this.initSearchData(el.items, key)
        }
        return this.setSearchData(el)
      })
    },
    setSearchData(item) {
      const key = item.key
      let data = this.formData[key]
      if (data !== 0 && !data) return
      const operation = this._.get(item, 'meta.operation', 'like')
      if (operation === 'like') {
        data = `%${data}%`
      }
      this.search.push([
        key,
        operation,
        data,
        {
          ...this._.get(item, 'meta', {})
        }
      ])
    },
    async handleSubmit() {
      await this.updateSearch({
        module: this.module,
        search: this.search
      })
      this.beforeChange()
      await this.getData()
      this.afterChange()
    }
  }
}
</script>
