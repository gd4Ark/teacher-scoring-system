<template>
    <v-card v-if="loaded"
            :title="title"
            class="table-card">
        <v-table ref="table"
                 :loading="loading"
                 :data="state.data"
                 :columns="columns"
                 :need-selection="false"
                 @sort-change="handleSortChange">
            <template slot="append">
                <el-table-column label="班级名称"
                                 prop="group_id"
                                 align="center"
                                 sortable="custom">
                    <template slot-scope="scope">
                        <span>{{ getGroupName(scope.row.group_id) }}</span>
                    </template>
                </el-table-column>
                <el-table-column label="所教科目"
                                 prop="subject_id"
                                 align="center">
                    <template slot-scope="scope">
                        <span>{{ getSubjectName(scope.row.subject_id) }}</span>
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
const __module = 'teachings'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ManageTable from '@/common/mixins/ManageTable'
import successMessage from '@/common/mixins/successMessage'
import { mapActions, mapState, mapMutations } from 'vuex'
export default {
    components: {
        vTable,
        Pagination
    },
    mixins: [ManageTable, successMessage],
    data: () => ({
        module: __module,
        columns: []
    }),
    computed: {
        ...mapState({
            state: __module
        }),
        ...mapState(['groups', 'subjects']),
        title() {
            const parent = this.state.parent
            return this.state[parent].name + ' 任课表'
        }
    },
    async created() {
        await this.getData()
        await this.getOptions('groups')
        await this.getOptions('subjects')
        this.loaded = true
        this.makeLoaded()
    },
    methods: {
        ...mapActions(['getOptions']),
        ...mapMutations(__module, {
            setOrder: 'update'
        }),
        getGroupName(id) {
            const item = this.groups.options.find(el => el.value === id)
            return item ? item.label : ''
        },
        getSubjectName(id) {
            const item = this.subjects.options.find(el => el.value === id)
            return item ? item.label : ''
        }
    }
}
</script>
