<template>
    <v-card v-if="loaded"
            :title="title"
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
                <el-table-column type="expand">
                    <template slot-scope="props">
                        <div class="suggest">
                            <p>建议：</p>
                            <pre>{{ props.row.suggest }}</pre>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="班级名称"
                                 prop="group_id"
                                 sortable="custom"
                                 align="center"
                                 min-width="130">
                    <template slot-scope="scope">
                        <span>{{ getGroupName(scope.row.group_id) }}</span>
                    </template>
                </el-table-column>
            </template>
            <template slot="append">
                <el-table-column label="建议字数"
                                 prop="suggest_len"
                                 sortable="custom"
                                 align="center"
                                 min-width="100">
                    <template slot-scope="scope">
                        <span>{{ scope.row.suggest_len }}</span>
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
const __module = 'scoresDetail'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ManageTable from '@/common/mixins/ManageTable'
import splitNameList from '@/common/mixins/splitNameList'
import successMessage from '@/common/mixins/successMessage'
import { mapActions, mapState, mapMutations } from 'vuex'
export default {
    components: {
        vTable,
        Pagination
    },
    mixins: [ManageTable, splitNameList, successMessage],
    data: () => ({
        module: __module,
        columns: [
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
                prop: 'total',
                label: '总分',
                sortable: 'custom',
                minWidth: 100
            }
        ]
    }),
    computed: {
        ...mapState({
            state: __module
        }),
        ...mapState(['groups', 'students']),
        title() {
            return (
                `${this.state.teacher.name} ` +
                `《${this.state.subject.name}》` +
                ' 分数表'
            )
        }
    },
    async created() {
        await this.getData()
        await this.getOptions('groups')
        this.loaded = true
        this.makeLoaded()
    },
    methods: {
        ...mapActions(['getOptions']),
        ...mapMutations(__module, {
            setOrder: 'update'
        }),
        exportExcel() {
            import('@/common/vendor/Export2Excel').then(excel => {
                const tHeader = [
                    '班级名称',
                    ...this.columns.map(el => el.label),
                    '建议'
                ]
                const filterVal = [
                    'group_id',
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
                    if (j === 'group_id') {
                        return this.getGroupName(v[j])
                    }
                    return v[j]
                })
            )
        },
        getGroupName(id) {
            const item = this.groups.options.find(el => el.value === id)
            return item ? item.label : ''
        }
    }
}
</script>
<style lang="scss" scoped>
.suggest {
    @include padding;
    pre {
        margin: 1rem 0;
        @include padding;
        text-indent: 2rem;
        border: 1px solid #eee;
    }
}
</style>
