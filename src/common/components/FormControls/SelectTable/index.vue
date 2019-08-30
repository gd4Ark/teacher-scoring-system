<template>
  <div class="select-table">
    <el-input v-model="value"
              :size="size"
              :placeholder="placeholder"
              :clearable="true"
              @click.native="onVisible" />
    <v-modal ref="modal"
             class="select-table__modal"
             :need-open-btn="false"
             :title="title"
             :need-footer="multiple"
             @submit="submit">
      <div slot="body"
           class="select-table__body">
        <base-search :module="module"
                     :get-data="getData"
                     @before-change="beforeChange"
                     @after-change="afterChange" />
        <s-table ref="table"
                 :module="module"
                 :table-columns="tableColumns"
                 :title="tableTitle"
                 :get-data="getData"
                 :multiple="multiple"
                 @current-change="onCurrentChange" />
      </div>
    </v-modal>
  </div>
</template>
<script>
import VModal from '@/common/components/VModal'
import BaseSearch from '@/common/components/BaseSearch'
import sTable from './components/SelectTable'
import syncChange from '@/common/mixins/syncChange'
export default {
  name: 'SelectTable',
  components: {
    VModal,
    BaseSearch,
    sTable
  },
  mixins: [syncChange],
  props: {
    module: {
      type: String,
      required: true
    },
    title: {
      type: String,
      default: '列表'
    },
    tableTitle: {
      type: String,
      default: '列表'
    },
    tableColumns: {
      type: Array,
      default: () => []
    },
    multiple: {
      type: Boolean,
      default: false
    },
    model: {
      type: [String, Number],
      required: true
    },
    size: {
      type: String,
      default: 'mini'
    },
    placeholder: {
      type: String,
      default: '请选择'
    },
    beforeSubmit: {
      type: Function,
      default: data => data
    }
  },
  data: () => ({
    value: ''
  }),
  watch: {
    model(model) {
      if (this._.isEqual(this.value, model)) {
        return
      }
      this.value = model
    }
  },
  created() {
    this.value = this.model
  },
  methods: {
    getData() {
      this.$store.dispatch(`${this.module}/getData`)
    },
    onVisible() {
      this.$refs.modal.visible()
    },
    onCurrentChange(data) {
      if (!data) return
      const val = this.beforeSubmit(data)
      this.$emit('update:model', val)
      this.$refs.modal.hidden()
    },
    submit() {}
  }
}
</script>
<style lang="scss" scoped>
.select-table__body {
    height: 100%;
    @include flex-column;
    /deep/ .table-card {
        flex: 1;
    }
}
.select-table__modal {
    /deep/ .el-dialog {
        max-width: 1150px;
        height: 900px;
    }
}
</style>
