<template>
    <v-card :title="title"
            class="table-card">
        <div slot="toolbar"
             class="toolbar">
            <modal-add :btn-size="respBtnSize"
                       :form-item="$v_data[module].add.item"
                       :get-form-data="$v_data[module].add.data"
                       :module="module"
                       :before-submit="splitNameList"
                       :success-message="successMessage"
                       title="添加教师"
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
            <el-table-column slot="append"
                             label="操作"
                             align="center"
                             min-width="200">
                <template slot-scope="scope">
                    <modal-edit :title="`编辑教师 ${scope.row.name } 中`"
                                :form-item="$v_data[module].edit.item"
                                :current="scope.row"
                                :module="module"
                                btn-size="mini"
                                @get-data="getData" />
                    <el-button size="mini"
                               @click="toTeaching(scope.row.id)">
                        查看任课
                    </el-button>
                    <el-button size="mini"
                               type="danger"
                               @click="handleDelete([scope.row.id])">
                        删除
                    </el-button>
                </template>
            </el-table-column>
        </v-table>

        <pagination :state="state"
                    :module="module"
                    :get-data="getData"
                    @before-change="beforeChange"
                    @after-change="afterChange" />
    </v-card>
</template>
<script>
const __module = 'teachers'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import splitNameList from '@/common/mixins/splitNameList'
import successMessage from '@/common/mixins/successMessage'
import { mapState, mapMutations } from 'vuex'
export default {
    components: {
        vTable,
        Pagination,
        ModalEdit,
        ModalAdd
    },
    mixins: [ManageTable, splitNameList, successMessage],
    props: {
        title: {
            type: String,
            default: '教师表'
        }
    },
    data: () => ({
        module: __module,
        columns: [
            {
                prop: 'name',
                label: '教师姓名',
                sortable: 'custom',
                minWidth: 100
            },
            {
                prop: 'teachings_count',
                label: '任课数量',
                sortable: 'custom',
                minWidth: 100
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
        this.makeLoaded()
    },
    methods: {
        ...mapMutations(__module, {
            setOrder: 'update'
        }),
        toTeaching(id) {
            this.$router.push({
                name: 'teacherTeachings',
                params: {
                    id
                }
            })
        }
    }
}
</script>
