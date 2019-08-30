<template>
  <div class="upload-container">
    <el-button :style="{ background: color,borderColor: color }"
               icon="el-icon-upload"
               size="mini"
               type="primary"
               @click=" dialogVisible = true">
      上传
    </el-button>
    <el-dialog :visible.sync="dialogVisible">
      <el-upload :multiple="true"
                 :file-list="fileList"
                 :show-file-list="true"
                 :on-remove="handleRemove"
                 :on-success="handleSuccess"
                 :before-upload="beforeUpload"
                 class="editor-slide-upload"
                 action=""
                 :http-request="onRquest"
                 list-type="picture-card">
        <el-button :size="respBtnSize"
                   type="primary">
          点击上传
        </el-button>
      </el-upload>
      <el-button :size="respBtnSize"
                 @click="dialogVisible = false">
        取消
      </el-button>
      <el-button type="primary"
                 :size="respBtnSize"
                 @click="handleSubmit">
        确认
      </el-button>
    </el-dialog>
  </div>
</template>

<script>
// import { getToken } from 'api/qiniu'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
import { info } from '@/common/utils/message'
export default {
  name: 'EditorSlideUpload',
  mixins: [ResponsiveSize],
  props: {
    color: {
      type: String,
      default: '#1890ff'
    }
  },
  data() {
    return {
      dialogVisible: false,
      listObj: {},
      fileList: []
    }
  },
  methods: {
    async onRquest({ file }) {
      const formData = new FormData()
      formData.append('img', file)
      return await this.$axios.upload('goods/upload/img', formData)
    },
    checkAllSuccess(arr) {
      return arr.every(item => {
        return item.hasSuccess
      })
    },
    handleSubmit() {
      const arr = Object.keys(this.listObj)
        .map(v => this.listObj[v])
        .filter(item => !this._.isEmpty(item))
      if (!this.checkAllSuccess(arr)) {
        info('请等待所有图片成功上传。如果出现网络问题，请刷新页面并重新上传！')
        return
      }
      this.$emit('successCBK', arr)
      this.listObj = {}
      this.fileList = []
      this.dialogVisible = false
    },
    handleSuccess(response, file) {
      const uid = file.uid
      const objKeyArr = Object.keys(this.listObj)
      for (let i = 0, len = objKeyArr.length; i < len; i++) {
        if (this.listObj[objKeyArr[i]].uid === uid) {
          this.listObj[objKeyArr[i]].url = response
          this.listObj[objKeyArr[i]].hasSuccess = true
          return
        }
      }
    },
    handleRemove(file) {
      const uid = file.uid
      const objKeyArr = Object.keys(this.listObj)
      for (let i = 0, len = objKeyArr.length; i < len; i++) {
        if (this.listObj[objKeyArr[i]].uid === uid) {
          delete this.listObj[objKeyArr[i]]
          return
        }
      }
    },
    beforeUpload(file) {
      const self = this
      const _URL = window.URL || window.webkitURL
      const fileName = file.uid
      this.listObj[fileName] = {}
      return new Promise((resolve, reject) => {
        const img = new Image()
        img.src = _URL.createObjectURL(file)
        img.onload = function() {
          self.listObj[fileName] = {
            hasSuccess: false,
            uid: file.uid,
            width: this.width,
            height: this.height
          }
        }
        resolve(true)
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.editor-slide-upload {
  margin-bottom: 20px;
  /deep/ .el-upload--picture-card {
    width: 100%;
  }
}
</style>
