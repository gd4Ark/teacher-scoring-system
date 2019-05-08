<template>
  <div class="inner-container">
    <el-row :gutter="20">
      <el-col :span="12">
        <v-card title="学生完成情况">
          <ve-pie ref="chart_studentComplete"
                  :data="studentComplete"></ve-pie>
        </v-card>
      </el-col>
      <el-col :span="12">
        <v-card title="班级完成情况">
          <ve-pie ref="chart_groupComplete"
                  :data="groupComplete"></ve-pie>
        </v-card>
      </el-col>
    </el-row>
    <el-row :gutter="20">
      <el-col :span="24">
        <v-card title="分数提交情况">
          <ve-line ref="chart_scoreComplete"
                   :data="scoreComplete"
                   :settings="scoreComplete.setting"></ve-line>
        </v-card>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import loading from '@/common/mixins/loading'
import VePie from 'v-charts/lib/pie.common'
import VeLine from 'v-charts/lib/line.common'
import 'v-charts/lib/style.css'
export default {
  mixins: [loading],
  components: {
    VePie,
    VeLine
  },
  data() {
    return {
      studentComplete: {
        columns: ['state', 'count'],
        rows: []
      },
      groupComplete: {
        columns: ['state', 'count'],
        rows: []
      },
      scoreComplete: {
        columns: ['date', 'count'],
        rows: [],
        setting: {
          labelMap: {
            count: '记录数量'
          }
        }
      }
    }
  },
  async created() {
    await this.init()
    await this.$nextTick(() => {
      Object.keys(this.$data).map(item => {
        if (this.$refs[`chart_${item}`]) {
          this.$refs[`chart_${item}`].echarts.resize()
        }
      })
      this.makeLoaded()
    })
  },
  methods: {
    async init() {
      await this.getStudentComplete()
      await this.getGroupComplete()
      await this.getScoreComplete()
    },
    async getStudentComplete() {
      this.studentComplete.rows = await this.$axios.get(
        '/students?getComplete=1'
      )
    },
    async getGroupComplete() {
      this.groupComplete.rows = await this.$axios.get('/groups?getComplete=1')
    },
    async getScoreComplete() {
      this.scoreComplete.rows = await this.$axios.get('/scores?getComplete=1')
    }
  }
}
</script>
<style lang="scss" scoped>
.inner-container {
  overflow-y: auto !important;
}
</style>
