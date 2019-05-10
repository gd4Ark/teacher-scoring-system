<template>
    <not-sub-router :name="module">
        <s-table ref="table"
                 :get-data="getData" />
    </not-sub-router>
</template>
<script>
const __module = 'archivesDetail'
import sTable from './components/ArchiveDetailTable'
import { mapActions, mapMutations } from 'vuex'
import syncChange from '@/common/mixins/syncChange'
export default {
    components: {
        sTable
    },
    mixins: [syncChange],
    data: () => ({
        module: __module
    }),
    async created() {
        this.setData({
            id: this.$route.params.id
        })
        this.getData()
    },
    methods: {
        ...mapActions(__module, ['getData']),
        ...mapMutations(__module, {
            setData: 'updateArachive'
        })
    }
}
</script>
