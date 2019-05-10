<template>
    <v-card :title="title"
            class="table-card">
        <v-table ref="table"
                 :loading="loading"
                 :data="state.data"
                 :columns="columns"
                 :need-selection="false"
                 @sort-change="handleSortChange">
            <template slot="append">
                <el-table-column label="操作"
                                 class-name="operate-col"
                                 align="center">
                    <template slot-scope="scope">
                        <el-button size="mini"
                                   @click="toArchivesDetail(scope.row.id)">
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
const __module = 'archives'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ManageTable from '@/common/mixins/ManageTable'
import splitNameList from '@/common/mixins/splitNameList'
import successMessage from '@/common/mixins/successMessage'
import { mapState, mapMutations } from 'vuex'
export default {
    components: {
        vTable,
        Pagination
    },
    mixins: [ManageTable, splitNameList, successMessage],
    props: {
        title: {
            type: String,
            default: '归档表'
        }
    },
    data: () => ({
        module: __module,
        columns: [
            {
                prop: 'name',
                label: '名称',
                sortable: 'custom'
            },
            {
                prop: 'created_at',
                label: '创建时间',
                sortable: 'custom'
            }
        ]
    }),
    computed: {
        ...mapState({
            state: __module
        })
    },
    async created() {
        await this.getData()
        this.loaded = true
        this.makeLoaded()
    },
    methods: {
        ...mapMutations(__module, {
            setOrder: 'update'
        }),
        toArchivesDetail(id) {
            this.$router.push({
                name: 'archivesDetail',
                params: {
                    id
                }
            })
        }
    }
}
</script>
