<template>
  <div class="app-container">
    <div class="inner-container">
      <div class="text">
        <h1>{{ $config.app_title }}</h1>
        <p>不忘初心，方得始终</p>
        <p>那些成功的人，往往是有着坚定目标，并持续努力的人</p>
      </div>
      <div class="login-panel">
        <el-card>
          <div class="card-header"
               slot="header">
            <h2 class="card-title">{{ $route.meta.title }}</h2>
          </div>
          <base-form btn="登录"
                     :form-item="$vData.login.item"
                     :get-form-data="$vData.login.data"
                     @submit="submit" />
        </el-card>
      </div>
    </div>
    <v-footer />
  </div>
</template>
<script>
import BaseForm from "@/common/components/BaseForm";
import vFooter from "@/common/layouts/Footer";
import { mapActions } from "vuex";
export default {
  components: {
    BaseForm,
    vFooter
  },
  methods: {
    ...mapActions(["login"]),
    async submit(formData) {
      await this.login({
        data: formData
      });
      this.$router.push("/index");
    }
  }
};
</script>

<style lang="scss" scoped>
.app-container {
  @include padding-x;
  @include flex-column;
  @include mask;
  justify-content: space-around;
  background: url("../../../common/images/login_bg.jpg");
  background-size: cover;
  .inner-container {
    flex: 1;
    @include sub-center;
    justify-content: space-around;
    .text {
      color: white;
      h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
      }
      p {
        line-height: 2.5;
      }
    }
    .login-panel {
      width: 400px;
    }
  }
}
.card-header {
  justify-content: center;
}
</style>
