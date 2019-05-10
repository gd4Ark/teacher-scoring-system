<template>
    <el-upload ref="upload"
               :file-list="fileList"
               :limit="item.limit || limit"
               :http-request="onRquest"
               :before-upload="onBeforeUpload"
               :on-exceed="onExceed"
               action=""
               drag>
        <i class="el-icon-upload" />
        <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
    </el-upload>
</template>
<script>
import { warning } from '@/common/utils/message'
export default {
    name: 'UploadControl',
    props: {
        item: {
            type: Object,
            required: true
        },
        model: {
            type: [Object, String, File],
            required: true
        }
    },
    data: () => ({
        default: {
            limit: 1,
            maxSize: 2,
            allowExtensions: []
        },
        fileList: [],
        file: ''
    }),
    computed: {
        limit() {
            return this.item.limit || this.default.limit
        },
        maxSize() {
            return this.item.maxSize || this.default.maxSize
        },
        allowExtensions() {
            return this.item.allowExtensions || this.default.allowExtensions
        },
        showAllowExtensions() {
            return this.allowExtensions.join('/')
        }
    },
    watch: {
        file(file) {
            this.$emit('update:model', file)
        },
        model(file) {
            if (!file) {
                return this.clearFiles()
            }
            if (this.file !== file) {
                this.file = file
            }
        }
    },
    methods: {
        onRquest({ file }) {
            this.file = file
        },
        onBeforeUpload(file) {
            if (!this.isAllowExtension(file)) {
                warning(`无法上传此格式的文件！`)
                return false
            }
            if (this.isLtMaxSize(file)) {
                warning(`文件最多可上传${this.maxSize}M！`)
                return false
            }
            return true
        },
        onExceed() {
            warning(`最多只能上传${this.limit}个文件`)
        },
        clearFiles() {
            this.fileList.length = 0
            this.$refs.upload.clearFiles()
        },
        isAllowExtension(file) {
            if (this.allowExtensions.length < 1) return true
            // const extension = file.name.split('.').pop()
            const toLow = str => str.toLocaleLowerCase
            return this.allowExtensions.find(
                el => toLow(el) === toLow(this.allowExtensions)
            )
        },
        isLtMaxSize(file) {
            return file.size / 1024 / 1024 > this.maxSize
        }
    }
}
</script>
<style lang="scss">
.el-upload {
    display: block;
}

.el-upload-dragger .el-icon-upload {
    margin: 0;
    font-size: 2.5rem;
}

.el-upload-dragger {
    @include flex-column;
    justify-content: center;
    @include wh(auto, 90px);
    padding: 0;
}
</style>
