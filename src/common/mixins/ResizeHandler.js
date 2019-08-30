const { body } = document
const WIDTH = 992 // refer to Bootstrap's responsive design

export default {
  watch: {},
  beforeMount() {
    window.addEventListener('resize', this.$_resizeHandler)
    this.$_resizeHandler()
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.$_resizeHandler)
  },
  methods: {
    // use $_ for mixins properties
    // https://vuejs.org/v2/style-guide/index.html#Private-property-names-essential
    $_isMobile() {
      const rect = body.getBoundingClientRect()
      return rect.width - 1 < WIDTH
    },
    $_resizeHandler() {
      if (!document.hidden) {
        const isMobile = this.$_isMobile()
        this.$store.dispatch(
          'app/toggleDevice',
          isMobile ? 'mobile' : 'desktop'
        )
        this.$store.dispatch('app/toggleSidebar', !isMobile)
      }
    }
  }
}
