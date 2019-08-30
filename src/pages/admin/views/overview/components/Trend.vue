<template>
  <v-card title="业绩走势">
    <div slot="toolbar"
         class="toolbar">
      <el-button :size="respBtnSize"
                 @click="changeType">
        切换
      </el-button>
    </div>
    <ve-chart v-if="!loading"
              ref="chart_trend"
              :data="trend"
              :data-zoom="zoom"
              :settings="settings" />
  </v-card>
</template>
<script>
const __module = 'overview.trend'
import loading from '@/common/mixins/loading'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
  mixins: [ResponsiveSize, loading],
  props: {
    data: {
      type: Array,
      required: true
    }
  },
  data() {
    const types = ['line', 'histogram']
    const index = 0
    return {
      module: __module,
      types: types,
      type_index: index,
      trend: {
        columns: ['date', 'count'],
        rows: []
      },
      settings: {
        labelMap: {
          date: '日期',
          count: '数量'
        },
        type: types[index]
      },
      zoom: [
        {
          type: 'slider',
          start: 0
        }
      ]
    }
  },
  async mounted() {
    this.trend.rows = this.data
    await this.$nextTick(async () => {
      this.$refs.chart_trend.echarts.resize()
      this.makeLoaded()
    })
  },
  methods: {
    async changeType() {
      this.type_index++
      if (this.type_index >= this.types.length) {
        this.type_index = 0
      }
      this.settings.type = this.types[this.type_index]
    }
  }
}
</script>
<style lang="scss" scoped>
.toolbar .el-form {
  padding-top: 0.7rem;
}
</style>