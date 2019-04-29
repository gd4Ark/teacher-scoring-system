<template>
  <v-card :title="title">
    <div class="toolbar"
         slot="toolbar">
      <el-button :size="respBtnSize"
                 type="primary"
                 @click="submit">搜索</el-button>
      <el-button :size="respBtnSize"
                 type="info"
                 @click="handleReset">重置</el-button>
    </div>
    <c-form :inline="true"
            :form-item="formItem"
            :form-data="formData"
            @submit="submit" />
  </v-card>
</template>
<script>
import cForm from '@/common/components/Form'
import { mapActions } from 'vuex'
import { firstUpperCase } from '@/common/utils'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
  name: 'Search',
  mixins: [ResponsiveSize],
  components: {
    cForm
  },
  props: {
    title: {
      type: String,
      default: '搜索'
    },
    module: String
  },
  data: () => ({
    search_keyword: []
  }),
  mounted() {
    this.reset()
  },
  methods: {
    ...mapActions(['resetSearchData', 'updateSearchKeyword']),
    reset() {
      this.resetSearchData(this.module)
    },
    handleReset() {
      this.reset()
      this.submit()
    },
    submit() {
      this.search_keyword = []
      this.formItem.forEach(el => {
        const key = el.key
        let item = this.formData[key]
        if (el.items) {
          el.items.forEach((el, index) => {
            if (item[index] !== 0 && !item[index]) return
            this.search_keyword.push([key, el.operation, item[index]])
          })
        } else {
          if (item !== 0 && !item) return
          const operation = el.operation
          if (operation === 'like') {
            item = `%${item}%`
          }
          this.search_keyword.push([key, operation, item])
        }
      })
      this.handleSubmit()
    },
    async handleSubmit() {
      await this.updateSearchKeyword({
        module: this.module,
        search_keyword: this.search_keyword
      })
      this.$emit('get-data')
    }
  },
  computed: {
    submitAction() {
      return `${this.module}search_keyword`
    },
    formItem() {
      return this.$v_data[this.module].search.item
    },
    formData() {
      return this.$store.state[this.module].search_data
    },
    s_module() {
      return firstUpperCase(this.module)
    }
  }
}
</script>
