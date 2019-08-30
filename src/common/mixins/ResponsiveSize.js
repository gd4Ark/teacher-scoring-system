import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters(['isMobile']),
    respBtnSize() {
      return this.isMobile ? 'mini' : 'mini'
    },
    respFormControlSize() {
      return this.isMobile ? 'mini' : 'mini'
    }
  }
}
