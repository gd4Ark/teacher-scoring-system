<template>
  <el-upload action=""
             :limit="item.limit || limit"
             :http-request="onRquest"
             :before-upload="onBeforeUpload"
             :on-exceed="onExceed"
             drag>
    <i class="el-icon-upload"></i>
    <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
    <div class="el-upload__tip"
         slot="tip">
      <template v-if="allowExtensions.length < 1">
        不限制文件格式
      </template>
      <template v-else>
        只能上传 {{ showAllowExtensions }} 文件
      </template>
      ，不可超过 {{ limit }} M。
    </div>
  </el-upload>
</template>
<script>
export default {
  props: {
    item: Object
  },
  data: () => ({
    default: {
      limit: 1,
      maxSize: 2,
      allowExtensions: []
    }
  }),
  methods: {
    onRquest(a) {
      console.log(a);
    },
    onBeforeUpload(file) {
      if (!this.isAllowExtension(file)) {
        this.$util.msg.warning(`无法上传此格式的文件！`);
        return false;
      }
      if (this.isLtMaxSize(file)) {
        this.$util.msg.warning(`文件最多可上传${this.maxSize}M！`);
        return false;
      }
      return true;
    },
    onExceed() {
      this.$util.msg.warning("最多只能上传一个文件");
    },
    isAllowExtension(file) {
      if (this.allowExtensions.length < 1) return true;
      const extension = file.name.split(".").pop();
      const toLow = str => str.toLocaleLowerCase;
      return this.allowExtensions.find(
        el => toLow(el) === toLow(this.allowExtensions)
      );
    },
    isLtMaxSize(file) {
      return file.size / 1024 / 1024 > this.maxSize;
    }
  },
  computed: {
    limit() {
      return this.item.limit || this.default.limit;
    },
    maxSize() {
      return this.item.maxSize || this.default.maxSize;
    },
    allowExtensions() {
      return this.item.allowExtensions || this.default.allowExtensions;
    },
    showAllowExtensions() {
      return this.allowExtensions.join("/");
    }
  }
};
</script>
