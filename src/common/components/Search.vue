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
import { isEmptyObject } from '@/common/utils/validate'
import getData from '@/common/mixins/getData'
import submitChange from '@/common/mixins/submitChange'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
    name: 'Search',
    components: {
        cForm
    },
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
            if (isEmptyObject(state.search_data)) {
                state.search_data = this.$v_data[this.module].search.data()
            }
            return state.search_data
        },
        s_module() {
            return firstUpperCase(this.module)
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
            this.formItem.forEach(el => {
                const key = el.key
                let item = this.formData[key]
                if (el.items) {
                    el.items.forEach((el, index) => {
                        if (item[index] !== 0 && !item[index]) return
                        this.search.push([key, el.operation, item[index]])
                    })
                } else {
                    if (item !== 0 && !item) return
                    const operation = el.operation
                    if (operation === 'like') {
                        item = `%${item}%`
                    }
                    this.search.push([key, operation, item])
                }
            })
            this.handleSubmit()
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
