<template>
    <v-card v-if="loaded"
            :title="title"
            class="table-card">
        <div slot="toolbar"
             class="toolbar">
            <modal-add :btn-size="respBtnSize"
                       :form-item="$v_data[module].form.item"
                       :get-form-data="$v_data[module].form.data"
                       :module="module"
                       :before-submit="beforeSubmit"
                       :success-message="successMessage"
                       title="添加学生"
                       @get-data="getData" />
            <el-button :size="respBtnSize"
                       type="danger"
                       @click="handleDelete(multipleSelection)">
                删除
            </el-button>
        </div>

        <v-table ref="table"
                 :loading="loading"
                 :data="state.data"
                 :columns="columns"
                 @selection-change="handleSelectionChange"
                 @sort-change="handleSortChange">
            <template slot="append">
                <el-table-column label="教师姓名"
                                 prop="teacher_id"
                                 align="center">
                    <template slot-scope="scope">
                        <span>{{ getTeacherName(scope.row.teacher_id) }}</span>
                    </template>
                </el-table-column>
                <el-table-column label="所教科目"
                                 prop="subject_id"
                                 align="center">
                    <template slot-scope="scope">
                        <span>{{ getSubjectName(scope.row.subject_id) }}</span>
                    </template>
                </el-table-column>
                <el-table-column label="操作"
                                 align="center"
                                 min-width="140">
                    <template slot-scope="scope">
                        <modal-edit :title="`编辑任课中`"
                                    :form-item="$v_data[module].form.item"
                                    :current="scope.row"
                                    :module="module"
                                    btn-size="mini"
                                    @get-data="getData" />
                        <el-button size="mini"
                                   type="danger"
                                   @click="handleDelete([scope.row.id])">
                            删除
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
const __module = 'teachings'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import splitNameList from '@/common/mixins/splitNameList'
import successMessage from '@/common/mixins/successMessage'
import { mapActions, mapState, mapMutations } from 'vuex'
export default {
    components: {
        vTable,
        Pagination,
        ModalEdit,
        ModalAdd
    },
    mixins: [ManageTable, splitNameList, successMessage],
    data: () => ({
        module: __module,
        columns: []
    }),
    computed: {
        ...mapState({
            state: __module
        }),
        ...mapState(['teachers', 'subjects']),
        title() {
            const parent = this.state.parent
            return this.state[parent].name + '课程表'
        }
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
        beforeSubmit(data) {
            data.group_id = this.state.group.id
            return data
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
