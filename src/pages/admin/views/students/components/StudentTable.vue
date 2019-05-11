<template>
    <v-card v-if="loaded"
            :title="title"
            class="table-card">
        <div slot="toolbar"
             class="toolbar">
            <modal-add :btn-size="respBtnSize"
                       :form-item="$v_data[module].add.item"
                       :get-form-data="$v_data[module].add.data"
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
                <el-table-column label="是否已评"
                                 align="center">
                    <template slot-scope="scope">
                        <span :class="['status',...getStatusClassName(scope.row.complete)]" />
                    </template>
                </el-table-column>
                <el-table-column label="操作"
                                 align="center"
                                 min-width="140">
                    <template slot-scope="scope">
                        <modal-edit :title="`编辑学生 ${scope.row.name } 中`"
                                    :form-item="$v_data[module].edit.item"
                                    :current="scope.row"
                                    :module="module"
                                    :before-submit="beforeEditSubmit"
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
const __module = 'students'
import vTable from '@/common/components/Table'
import Pagination from '@/common/components/Pagination'
import ModalEdit from '@/common/components/ModalEdit'
import ModalAdd from '@/common/components/ModalAdd'
import ManageTable from '@/common/mixins/ManageTable'
import filterName from '@/common/mixins/filterName'
import successMessage from '@/common/mixins/successMessage'
import getStatusClassName from '@/common/mixins/getStatusClassName'
import { mapState, mapMutations } from 'vuex'
export default {
    components: {
        vTable,
        Pagination,
        ModalEdit,
        ModalAdd
    },
    mixins: [ManageTable, successMessage, filterName, getStatusClassName],
    data: () => ({
        module: __module,
        columns: [
            {
                prop: 'name',
                label: '学生姓名',
                sortable: 'custom',
                minWidth: 100
            }
        ]
    }),
    computed: {
        ...mapState({
            state: __module
        }),
        title() {
            const parent = this.state.parent
            return this.state[parent].name + ' 学生表'
        }
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
        beforeSubmit(data) {
            data = this.beforeAddSubmit(data)
            data.group_id = this.$route.params.id
            return data
        }
    }
}
</script>
