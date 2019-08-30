<template>
  <div v-if="loaded"
       class="inner-container overview-container">
    <el-row>
      <count :data="count" />
    </el-row>
    <el-row :gutter="20">
      <el-col :span="24">
        <trend ref="trend"
               :data="scores" />
      </el-col>
    </el-row>
    <el-divider content-position="center">完成情况</el-divider>
    <el-row :gutter="10">
      <el-col :span="12">
        <v-card title="学生完成情况">
          <ve-pie ref="chart_student"
                  :data="student" />
        </v-card>
      </el-col>
      <el-col :span="12">
        <v-card title="班级完成情况">
          <ve-pie ref="chart_group"
                  :data="group" />
        </v-card>
      </el-col>
    </el-row>
  </div>
</template>
<script>
const __module = 'overview'
import 'echarts/lib/component/dataZoom'
import 'v-charts/lib/style.css'
import loading from '@/common/mixins/loading'
import Count from './components/Count'
import Trend from './components/Trend'
export default {
  components: {
    Count,
    Trend
  },
  mixins: [loading],
  data() {
    return {
      module: __module,
      loaded: false,
      student: {
        columns: ['state', 'count'],
        rows: []
      },
      group: {
        columns: ['state', 'count'],
        rows: []
      },
      scores: {},
      count: {}
    }
  },
  async created() {
    await this.$nextTick(async () => {
      await this.init()
      Object.keys(this.$refs).forEach(item => {
        if (item.indexOf('chart') === 0) {
          this.$refs[item].echarts.resize()
        }
      })
      this.makeLoaded()
    })
  },
  methods: {
    async init() {
      await this.getData()
      this.loaded = true
    },
    async getData() {
      const data = await this.$axios.get('/index')
      const { complete_info: complete } = data
      this.student.rows = complete.student
      this.group.rows = complete.group
      this.scores = complete.scores
      this.count = data.count
    }
  }
}
</script>
<style lang="scss" scoped>
.inner-container {
  overflow-y: auto !important;
  /deep/ .turnover-type-select {
    .el-input__inner {
      border: none;
    }
  }
}
.info .info-box {
  @include flex;
  .icon-container {
    width: 20%;
    @include sub-center;
    .icon {
      color: white;
      font-size: 2.5rem;
    }
  }
  .content {
    flex: 1;
    @include sub-center;
    @include flex-column;
    line-height: 2;
    .count {
      font-size: 2.5rem;
    }
  }
}
</style>
