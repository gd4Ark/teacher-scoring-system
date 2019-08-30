import { mapGetters } from 'vuex'
import { toRoles } from '@/common/utils/role'
export default {
  computed: {
    ...mapGetters(['meRole'])
  },
  methods: {
    hasRole(roles) {
      const _roles = toRoles(roles)
      return _roles.some(role => role === this.myRole)
    }
  }
}
