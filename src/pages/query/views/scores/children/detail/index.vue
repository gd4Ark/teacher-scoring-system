<template>
  <not-sub-router :name="module">
    <search
      :module="module"
      :get-data="getData"
      @before-change="beforeChange"
      @after-change="afterChange"
    />
    <s-table
      ref="table"
      :get-data="getData"
    />
  </not-sub-router>
</template>
<script>
const __module = 'scoresDetail'
import Search from '@/common/components/Search'
import sTable from './components/ScoreDetailTable'
import { mapActions, mapMutations } from 'vuex'
import syncChange from '@/common/mixins/syncChange'
export default {
    components: {
        sTable,
        Search
    },
    mixins: [syncChange],
    data: () => ({
        module: __module
    }),
    async created() {
        this.setData({
            subject: {
                id: this.$route.params.sid
            },
            teacher: {
                id: this.$route.params.tid
            }
        })
        this.getData()
    },
    methods: {
        ...mapActions(__module, ['getData']),
        ...mapMutations(__module, {
            setData: 'update'
        })
    }
}
</script>
