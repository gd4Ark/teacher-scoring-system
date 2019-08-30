<template>
  <div class="inner-container">
    <div class="wscn-http404">
      <div class="pic-404">
        <img class="pic-404__parent"
             src="@/static/images/404_images/404.svg"
             alt="404">
      </div>
      <div class="bullshit">
        <div class="bullshit__oops">页面找不到！</div>
        <div class="bullshit__headline">{{ message }}</div>
        <div class="bullshit__info">请检查您输入的URL是否正确，或单击下面的按钮返回主页。</div>
        <a class="bullshit__return bullshit__return-back"
           @click="toBack">
          上一页
        </a>
        <router-link to="/"
                     class="bullshit__return bullshit__return-home">
          回到首页
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Page404',
  computed: {
    message() {
      return '网站管理员说您无法进入此页面...'
    }
  },
  methods: {
    toBack() {
      this.$router.back()
    }
  }
}
</script>

<style lang="scss" scoped>
.inner-container {
  @include sub-center;
}
.wscn-http404 {
  @include sub-center;
  width: 80%;
  position: relative;
  overflow: hidden;
  .pic-404 {
    @include wh(30vw, 15.5vw);
    &__parent {
      @include wh(100%);
    }
  }
  .bullshit {
    flex: 1;
    position: relative;
    float: left;
    overflow: hidden;
    &__oops {
      font-size: 32px;
      font-weight: bold;
      line-height: 40px;
      color: #1482f0;
      opacity: 0;
      margin-bottom: 20px;
      animation-name: slideUp;
      animation-duration: 0.5s;
      animation-fill-mode: forwards;
    }
    &__headline {
      font-size: 20px;
      line-height: 24px;
      color: #222;
      font-weight: bold;
      opacity: 0;
      margin-bottom: 10px;
      animation-name: slideUp;
      animation-duration: 0.5s;
      animation-delay: 0.1s;
      animation-fill-mode: forwards;
    }
    &__info {
      font-size: 13px;
      line-height: 21px;
      color: grey;
      opacity: 0;
      margin-bottom: 30px;
      animation-name: slideUp;
      animation-duration: 0.5s;
      animation-delay: 0.2s;
      animation-fill-mode: forwards;
    }
    &__return {
      margin-left: 5px;
      display: block;
      float: left;
      width: 88px;
      height: 29px;
      background: #1482f0;
      border-radius: 100px;
      text-align: center;
      color: #ffffff;
      opacity: 0;
      font-size: 0.85rem;
      line-height: 29px;
      cursor: pointer;
      animation-name: slideUp;
      animation-duration: 0.5s;
      animation-delay: 0.3s;
      animation-fill-mode: forwards;
    }
    @keyframes slideUp {
      0% {
        transform: translateY(60px);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }
  }
}
</style>
