<template>
  <div class="inner-container">
    <v-card title="修改密码">
      <base-form btn="修改"
                 :form-item="$v_data.password.item"
                 :get-form-data="$v_data.password.data"
                 @submit="submit" />
    </v-card>
  </div>
</template>
<script>
import { warning, success } from '@/common/utils/message'
import BaseForm from '@/common/components/BaseForm'
import { mapActions } from 'vuex'
export default {
  components: {
    BaseForm
  },
  methods: {
    ...mapActions(['resetPassword']),
    async submit(data) {
      const { password, password_confirm } = data
      if (password !== password_confirm) {
        return warning('密码不一致！')
      }
      await this.resetPassword({
        data
      })
      await success('修改成功！')
      this.$router.push('/login')
    }
  }
}
</script>