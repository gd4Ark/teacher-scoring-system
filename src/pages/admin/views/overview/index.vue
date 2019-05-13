<template>
    <div class="inner-container">
        <el-row class="info"
                :gutter="20">
            <el-col v-for="(item,index) in countData"
                    :key="index"
                    :span="6">
                <v-card :need-header="false">
                    <div class="info-box">
                        <div class="icon-container"
                             :style="{background:item.color}">
                            <i :class="['icon',item.icon]"></i>
                        </div>
                        <div class="content">
                            <count-to :key="index"
                                      :start-val="0"
                                      :end-val="item.count"
                                      :duration="1"
                                      class="count" />
                            <p class="title">{{ item.title }}</p>
                        </div>
                    </div>
                </v-card>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="12">
                <v-card title="学生完成情况">
                    <ve-pie ref="chart_studentComplete"
                            :data="studentComplete" />
                </v-card>
            </el-col>
            <el-col :span="12">
                <v-card title="班级完成情况">
                    <ve-pie ref="chart_groupComplete"
                            :data="groupComplete" />
                </v-card>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="24">
                <v-card title="分数提交情况">
                    <ve-line ref="chart_scoreComplete"
                             :data="scoreComplete"
                             :settings="scoreComplete.setting" />
                </v-card>
            </el-col>
        </el-row>
    </div>
</template>
<script>
import loading from '@/common/mixins/loading'
import CountTo from 'vue-count-to'
import VePie from 'v-charts/lib/pie.common'
import VeLine from 'v-charts/lib/line.common'
import 'v-charts/lib/style.css'
export default {
    components: {
        CountTo,
        VePie,
        VeLine
    },
    mixins: [loading],
    data() {
        return {
            countData: [
                {
                    prop: 'student_count',
                    title: '学生数量',
                    icon: 'el-icon-ali-jiaoshi',
                    count: 0,
                    color: '#2d8cf0'
                },
                {
                    prop: 'group_count',
                    title: '班级数量',
                    icon: 'el-icon-ali-jiaoshi',
                    count: 0,
                    color: '#19be6b'
                },
                {
                    prop: 'teacher_count',
                    title: '教师数量',
                    icon: 'el-icon-ali-jiaoshi',
                    count: 0,
                    color: '#ff9900'
                },
                {
                    prop: 'subject_count',
                    title: '科目数量',
                    icon: 'el-icon-ali-jiaoshi',
                    count: 0,
                    color: '#ed3f14'
                }
            ],
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
            await this.getCountData()
        },
        async getStudentComplete() {
            this.studentComplete.rows = await this.$axios.get(
                '/students?getComplete=1'
            )
        },
        async getGroupComplete() {
            this.groupComplete.rows = await this.$axios.get(
                '/groups?getComplete=1'
            )
        },
        async getScoreComplete() {
            this.scoreComplete.rows = await this.$axios.get(
                '/scores?getComplete=1'
            )
        },
        async getCountData() {
            const counts = {
                student_count: await this.$axios.get('/students?getCount=1'),
                group_count: await this.$axios.get('/groups?getCount=1'),
                teacher_count: await this.$axios.get('/teachers?getCount=1'),
                subject_count: await this.$axios.get('/subjects?getCount=1')
            }
            Object.keys(counts).forEach(key => {
                const curr = this.countData.find(el => el.prop === key)
                if (curr) {
                    curr.count = counts[key]
                }
            })
        }
    }
}
</script>
<style lang="scss" scoped>
.inner-container {
    overflow-y: auto !important;
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
