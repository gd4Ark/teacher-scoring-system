<template>
  <div class="inner-container">
    <div :class="['login-container',device]">
      <div v-if="!isMobile"
           class="login-text">
        <h1 class="title">教师评分系统</h1>
        <p class="message">
          <span>不忘初心，方得始终</span>
          <span>那些成功的人，往往是有着坚定目标，并持续努力的人</span>
        </p>
      </div>
      <div class="login-panel">
        <el-card>
          <div slot="header"
               class="card-header">
            <h2 class="card-title"></h2>
          </div>
          <base-form :form-item="$v_data[module].login.item"
                     :get-form-data="$v_data[module].login.data"
                     :show-label="false"
                     btn-size="mini"
                     :btn-style="{ width: '100%' }"
                     :need-reset-btn="false"
                     submit-btn-text="登录"
                     @submit="submit" />
        </el-card>
      </div>
    </div>
    <v-footer />
  </div>
</template>
<script>
const __module = 'admin'
import BaseForm from '@/common/components/BaseForm'
import vFooter from '@/common/layouts/Footer'
import getRedirect from '@/common/mixins/getRedirect'
import { mapActions, mapGetters } from 'vuex'
export default {
  components: {
    BaseForm,
    vFooter
  },
  mixins: [getRedirect],
  data: () => ({
    module: __module
  }),
  computed: {
    ...mapGetters(['device', 'isMobile', 'title']),
    loginTitle() {
      return this.isMobile
        ? this.$config.app_title + '-' + this.$route.meta.title
        : this.$route.meta.title
    }
  },
  methods: {
    ...mapActions(__module, ['login', 'getProfile']),
    async submit(data) {
      await this.login({
        data
      })
      await this.getProfile()
      //   this.$root.$children[0].initNavList()
      this.$router.push({
        path: this.redirect || '/index',
        query: this.otherQuery
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.app-footer {
  color: white;
  opacity: 0.6;
}
</style>

<style lang="scss" scoped>
.inner-container {
  @include padding-x;
  @include flex-column;
  justify-content: space-around;
  background: url('../../static/images/login_bg.jpg');
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
    /deep/ .el-card__body {
      padding-top: 15px;
    }
    /deep/ .el-form-item__content {
      line-height: 28px;
    }
    /deep/ .el-form-item {
      margin-bottom: 7px;
    }
    /deep/ .el-button--mini {
      padding: 7px 8px;
    }
  }
}
.card-header {
  justify-content: center;
}
</style>
