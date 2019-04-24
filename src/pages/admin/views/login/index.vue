<template>
  <div class="inner-container">
    <div :class="['login-container',device]">
      <div class="login-text"
           v-if="!isMobile">
        <h1 class="title">{{ $config.app_title }}</h1>
        <p class="message">
          <span>不忘初心，方得始终</span>
          <span>那些成功的人，往往是有着坚定目标，并持续努力的人</span>
        </p>
      </div>
      <div class="login-panel">
        <el-card>
          <div class="card-header"
               slot="header">
            <h2 class="card-title">{{ loginTitle }}</h2>
          </div>
          <base-form btn-text="登录"
                     :form-item="$v_data.login.item"
                     :get-form-data="$v_data.login.data"
                     :show-label="false"
                     :btn-size="btnSize"
                     :btn-style="{width:'100%'}"
                     @submit="submit" />
        </el-card>
      </div>
    </div>
    <v-footer />
  </div>
</template>
<script>
import BaseForm from '@/common/components/BaseForm'
import vFooter from '@/common/layouts/Footer'
import { mapActions, mapGetters } from 'vuex'
export default {
  components: {
    BaseForm,
    vFooter
  },
  methods: {
    ...mapActions('user', ['login']),
    async submit(data) {
      await this.login({
        data
      })
      this.$router.push('/index')
    }
  },
  computed: {
    ...mapGetters(['device', 'isMobile']),
    btnSize() {
      return this.isMobile ? 'small' : 'medium'
    },
    loginTitle() {
      return this.isMobile
        ? this.$config.app_title + '-' + this.$route.meta.title
        : this.$route.meta.title
    }
  }
}
</script>

<style lang="scss" scoped>
.inner-container {
  @include padding-x;
  @include flex-column;
  justify-content: space-around;
  background: url('../../../../common/images/login_bg.jpg');
  background-size: cover;
  position: relative;
  z-index: 1;
  &::after {
    content: '';
    @include mask(-1);
  }
  .login-container {
    flex: 1;
    &.desktop {
      @include sub-center;
      justify-content: space-around;
    }
    &.mobile {
      padding: 60% 0;
      @include flex-column;
      @include sub-center;
      justify-content: space-around;
      .login-panel {
        width: 95%;
      }
    }
    .login-text {
      color: white;
      .title {
        font-size: 2.3rem;
        margin-bottom: 1rem;
      }
      .message {
        span {
          display: block;
        }
        line-height: 2.5;
      }
    }
    .login-panel {
      width: 350px;
    }
  }
}
.card-header {
  justify-content: center;
}
</style>