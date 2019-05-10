<template>
    <not-sub-router :name="module">
        <search :module="module"
                :get-data="getData"
                @before-change="beforeChange"
                @after-change="afterChange" />
        <s-table ref="table"
                 :get-data="getData" />
    </not-sub-router>
</template>
<script>
const __module = 'subjects'
import Search from '@/common/components/Search'
import sTable from './components/SubjectTable'
import { mapActions } from 'vuex'
import syncChange from '@/common/mixins/syncChange'
export default {
    components: {
        Search,
        sTable
    },
    mixins: [syncChange],
    data: () => ({
        module: __module
    }),
    methods: {
        ...mapActions(__module, ['getData'])
    }
}
</script>
