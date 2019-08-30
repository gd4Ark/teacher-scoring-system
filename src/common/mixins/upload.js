import { warning } from '@/common/utils/message'
import { isFile } from '@/common/utils'
export default {
  props: {
    item: {
      type: Object,
      required: true
    },
    model: {
      type: [File, String, Array, Object],
      required: true
    }
  },
  watch: {
    files(files) {
      this.updateFiles(files)
    },
    model(files) {
      if (this._.isEmpty(files) && !this._.isEmpty(this.files)) {
        return this.clearFiles()
      }
      if (this._.isArray(files)) {
        if (files.some(item => item.size)) return
        if (this.isEqualURL(files)) return
      }
      if (files.pre) {
        return
      }
      if (isFile(files)) return
      if (this._.isEqual(this.files, files)) return
      if (!this._.isEmpty(files)) {
        return this.initUrl(files)
      }
    }
  },
  data: () => ({
    default: {
      limit: 1,
      maxSize: 2,
      allowExtensions: []
    },
    dialogImageUrl: '',
    dialogVisible: false,
    files: [],
    fileList: []
  }),
  computed: {
    itemMeta() {
      return this._.get(this.item, 'meta', {})
    },
    hiddenUpload() {
      return this.files.length >= this.limit
    },
    limit() {
      return this.itemMeta.limit || this.default.limit
    },
    maxSize() {
      return this.itemMeta.max_size || this.default.maxSize
    },
    allowExtensions() {
      return (
        this.itemMeta.allow_extensions || this.default.allowExtensions
      )
    },
    showAllowExtensions() {
      return this.allowExtensions.join('/')
    }
  },
  mounted() {
    this.updateFiles(this.files)
  },
  methods: {
    updateFiles(files) {
      const isMultiple = this.limit > 1
      let res = isMultiple ? files : files[0]
      res = res || (isMultiple ? [] : '')
      this.$emit('update:model', res)
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
    onRquest({ file }, fileList) {
      this.files.push(file)
    },
    onRemove(file, fileList) {
      this.setFiles(fileList)
    },
    setFiles(fileList) {
      this.files = this._.clone(fileList)
    },
    clearFiles() {
      this.fileList = []
      this.files = []
      this.$refs.upload.clearFiles()
    },
    isAllowExtension(file) {
      if (this.allowExtensions.length < 1) return true
      const extension = file.name.split('.').pop()
      const toLow = str => str.toLocaleLowerCase()
      return this.allowExtensions.find(
        el => toLow(el) === toLow(extension)
      )
    },
    isLtMaxSize(file) {
      return file.size / 1024 / 1024 > this.maxSize
    },
    initFileList() {
      const { model } = this
      this.initUrl(model)
    },
    initUrl(paths) {
      if (!this._.isArray(paths)) {
        paths = [paths]
      }
      this.fileList = paths.map(item => {
        return {
          url: item,
          pre: true
        }
      })
      this.setFiles(this.fileList)
    },
    isEqualURL(files) {
      return this._.isEqual(this.files.map(item => item.url), files)
    }
  }
}
