<template>
    <v-card :title="title"
            class="table-card">
        <div slot="toolbar"
             class="toolbar">
            <el-button :size="respBtnSize"
                       type="primary"
                       icon="el-icon-download"
                       @click="exportExcel">
                导出
            </el-button>
        </div>
        <v-table ref="table"
                 :loading="loading"
                 :data="state.data"
                 :columns="columns"
                 :need-selection="false"
                 @sort-change="handleSortChange">
            <template slot="prepend">
                <el-table-column label="教师姓名"
                                 prop="teacher_id"
                                 align="center">
                    <template slot-scope="scope">
                        <span>{{ getTeacherName(scope.row.teacher_id) }}</span>
                    </template>
                </el-table-column>
                <el-table-column label="所教科目"
                                 prop="subject_id"
                                 align="center"
                                 min-width="100">
                    <template slot-scope="scope">
                        <span>{{ getSubjectName(scope.row.subject_id) }}</span>
                    </template>
                </el-table-column>
            </template>
            <template slot="append">
                <el-table-column label="操作"
                                 class-name="operate-col"
                                 align="center">
                    <template slot-scope="scope">
                        <el-button size="mini"
                                   @click="toScoresDetail(scope.row.subject_id,scope.row.teacher_id)">
                            查看明细
                        </el-button>
                    </template>
                </el-table-column>
            </template>
        </v-table>

        <pagination :state="state"
                    :module="module"
                    :get-data="getData"
                    @before-change="beforeChange"
                    @after-change="afterChange" />
    </v-card>
</template>
<script>
const __module = 'scores'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ManageTable from '@/common/mixins/ManageTable'
import { mapActions, mapState, mapMutations } from 'vuex'
export default {
    components: {
        vTable,
        Pagination
    },
    mixins: [ManageTable],
    props: {
        title: {
            type: String,
            default: '分数表'
        }
    },
    data: () => ({
        module: __module,
        columns: [
            {
                prop: 'student_count',
                label: '评分人数',
                sortable: 'custom',
                minWidth: 100
            },
            {
                prop: '教学能力',
                label: '教学能力',
                sortable: 'custom',
                minWidth: 100
            },
            {
                prop: '教学水平',
                label: '教学水平',
                sortable: 'custom',
                minWidth: 100
            },
            {
                prop: '教学效果',
                label: '教学效果',
                sortable: 'custom',
                minWidth: 100
            },
            {
                prop: 'avg',
                label: '平均分',
                sortable: 'custom'
            }
        ]
    }),
    computed: {
        ...mapState({
            state: __module
        }),
        ...mapState(['teachers', 'subjects'])
    },
    async created() {
        await this.getData()
        await this.getOptions('teachers')
        await this.getOptions('subjects')
        this.loaded = true
        this.makeLoaded()
    },
    methods: {
        ...mapActions(['getOptions']),
        ...mapMutations(__module, {
            setOrder: 'update'
        }),
        async archive(data) {
            await this.$axios.post(`/archives`, data)
            return true
        },
        exportExcel() {
            import('@/common/vendor/Export2Excel').then(excel => {
                const tHeader = [
                    '教师名字',
                    '所教科目',
                    ...this.columns.map(el => el.label)
                ]
                const filterVal = [
                    'subject_id',
                    'teacher_id',
                    ...this.columns.map(el => el.prop)
                ]
                const data = this.formatJson(filterVal, this.state.data)
                excel.export_json_to_excel({
                    header: tHeader,
                    data,
                    filename: this.title
                })
            })
        },
        formatJson(filterVal, jsonData) {
            return jsonData.map(v =>
                filterVal.map(j => {
                    if (j === 'subject_id') {
                        return this.getSubjectName(v[j])
                    } else if (j === 'teacher_id') {
                        return this.getTeacherName(v[j])
                    }
                    return v[j]
                })
            )
        },
        toScoresDetail(sid, tid) {
            this.$router.push({
                name: 'scoresDetail',
                params: {
                    sid: sid,
                    tid: tid
                }
            })
        },
        getTeacherName(id) {
            const item = this.teachers.options.find(el => el.value === id)
            return item ? item.label : ''
        },
        getSubjectName(id) {
            const item = this.subjects.options.find(el => el.value === id)
            return item ? item.label : ''
        }
    }
}
</script>
