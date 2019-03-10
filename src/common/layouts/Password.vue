<template>
  <wrap>
    <div class="app-container">
      <v-card title="修改密码">
        <add :formItem="$vData.user.userPassword.item"
             :getFormData="$vData.user.userPassword.data"
             @submit="submit"
             btnText="修改" />
      </v-card>
    </div>
  </wrap>
</template>
<script>
import Add from "@/common/components/Add";
import { mapActions } from "vuex";
export default {
  components: {
    Add
  },
  methods: {
    ...mapActions(["updatePassword"]),
    async submit(formData) {
      const { new_password, new_password2 } = formData;
      if (new_password !== new_password2) {
        return this.$util.msg.warning("密码不一致！");
      }
      await this.updatePassword({
        data: formData
      });
      await this.$util.msg.success("修改成功！");
      this.$router.push("/login");
    }
  }
};
</script>
