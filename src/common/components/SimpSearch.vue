  <template>
  <v-card :title="title"
          class="search">
    <div slot="toolbar"
         class="toolbar">
      <el-button :size="respBtnSize"
                 type="primary"
                 @click="handleSubmit">
        {{ submitBtnText }}
      </el-button>
      <el-button :size="respBtnSize"
                 type="info"
                 @click="handleReset">
        重置
      </el-button>
    </div>
    <base-form ref="baseForm"
               :show-message="false"
               :inline="true"
               :form-item="moduleData.item"
               :get-form-data="moduleData.data"
               :need-submit-btn="false"
               :need-reset-btn="false"
               @submit="submit" />
  </v-card>
</template>
<script>
import BaseForm from '@/common/components/BaseForm'
import ResponsiveSize from '@/common/mixins/ResponsiveSize'
export default {
  name: 'SimpSearch',
  components: {
    BaseForm
  },
  mixins: [ResponsiveSize],
  props: {
    title: {
      type: String,
      default: '搜索'
    },
    submitBtnText: {
      type: String,
      default: '搜索'
    },
    module: {
      type: String,
      required: true
    }
  },
  computed: {
    moduleData() {
      return this._.get(this.$v_data, this.module).search
    }
  },
  methods: {
    handleSubmit() {
      this.$refs.baseForm.submit()
    },
    handleReset() {
      this.$refs.baseForm.resetForm()
    },
    submit(data) {
      this.$emit('submit', data)
    }
  }
}
</script>
