<template>
  <div class="upload-pic-container">
    <el-upload ref="upload"
               :class="['avatar-uploader',{ 'hidden-upload': hiddenUpload }]"
               action=""
               list-type="picture-card"
               :limit="limit"
               :multiple="_.get(item,'meta.multiple')"
               :file-list.sync="fileList"
               :http-request="onRquest"
               :before-upload="onBeforeUpload"
               :on-preview="onPreview"
               :on-remove="onRemove"
               :on-exceed="onExceed"
               drag>
      <i class="el-icon-plus"></i>
    </el-upload>
    <el-dialog :visible.sync="dialogVisible">
      <img width="100%"
           :src="dialogImageUrl">
    </el-dialog>
  </div>
</template>

<script>
import upload from '@/common/mixins/upload'
export default {
  name: 'UploadPicControl',
  mixins: [upload],
  data: () => ({
    default: {
      limit: 1,
      maxSize: 2,
      allowExtensions: ['webp', 'jpg', 'png']
    }
  }),
  methods: {
    onPreview(file) {
      this.dialogImageUrl = file.url
      this.dialogVisible = true
    }
  }
}
</script>
<style lang="scss" scoped>
.hidden-upload {
  /deep/ .el-upload--picture-card {
    display: none;
  }
}
</style>

