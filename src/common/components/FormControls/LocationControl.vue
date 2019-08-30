<template>
  <div class="location-control">
    <el-input v-model="strVal"
              :size="size"
              :placeholder="placeholder"
              :readonly="true"
              @click.native="onVisible" />
    <v-modal ref="modal"
             btn-size="mini"
             title="选择位置信息"
             :need-footer="false"
             :need-open-btn="false">
      <div slot="body"
           class="search">
        <map-search @click="onClick" />
      </div>
    </v-modal>
  </div>
</template>
<script>
import VModal from '@/common/components/VModal'
import MapSearch from './AMapSearch'
export default {
  name: 'LocationControl',
  components: {
    VModal,
    MapSearch
  },
  props: {
    model: {
      type: Array,
      required: true
    },
    size: {
      type: String,
      default: 'mini'
    },
    placeholder: {
      type: String,
      default: '请输入位置'
    }
  },
  data: () => ({
    showSearch: false
  }),
  computed: {
    strVal() {
      return String(this.model)
    }
  },
  methods: {
    onVisible() {
      this.$refs.modal.visible()
    },
    onClick(data) {
      const { lng, lat } = data
      this.$emit('update:model', [lng, lat])
      this.$refs.modal.hidden()
    }
  }
}
</script>
<style lang="scss" scoped>
.search {
  height: 500px;
  /deep/ .amap {
    height: 100%;
  }
}
</style>
