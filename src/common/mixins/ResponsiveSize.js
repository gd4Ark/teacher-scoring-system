import {
    mapGetters
} from 'vuex'
export default {
    computed: {
        ...mapGetters(['isMobile']),
        respBtnSize() {
            return this.isMobile ? 'mini' : 'small'
        },
        respFormControlSize() {
            return this.isMobile ? 'small' : ''
        }
    }
}