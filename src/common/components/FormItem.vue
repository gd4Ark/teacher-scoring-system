<template>
    <div class="el-form-item el-form-item-container">
        <!-- is group -->
        <template v-if="item.isGroup">
            <form-item v-for="(subItem) in item.group"
                       :key="getKey(subItem)"
                       :splice-key="getKey(subItem)"
                       :item="subItem"
                       :rules="rules"
                       :form-item="formItem"
                       :form-data="formData" />
        </template>
        <!-- is multiple -->
        <template v-else-if="item.isMultiple">
            <form-item v-for="(subItem,subIndex) in item.items"
                       :key="subIndex"
                       :item="subItem"
                       :rules="rules"
                       :form-item="formItem"
                       :form-data="formData"
                       :splice-key="subItem.key" />
        </template>
        <!-- is tab -->
        <template v-else-if="item.isTab">
            <el-tabs v-model="item.activeName">
                <el-tab-pane v-for="(subItem,subIndex) in item.items"
                             :key="subIndex"
                             :label="subItem.title"
                             :name="subItem.key"
                             :lazy="true">
                    <form-item :item="subItem"
                               :form-item="formItem"
                               :form-data="formData"
                               :rules="rules"
                               :splice-key="subItem.key" />
                </el-tab-pane>
            </el-tabs>
        </template>
        <template v-else-if="item.isTitle">
            <el-divider>{{ item.title }}</el-divider>
        </template>
        <template v-else>
            <!-- 一行多个 -->
            <template v-if="item.items">
                <el-form-item v-for="(subItem) in item.items"
                              :key="getKey(subItem)"
                              :label="subItem.label"
                              :prop="spliceKey +'.'+ subItem.key"
                              :class="{hidden : !showWhen(subItem.enableWhen)}"
                              :style="getStyle(subItem)">
                    <span v-show="false">{{ setModel(spliceKey +'.'+ subItem.key) }}</span>
                    <form-control :item="subItem"
                                  :model.sync="model[subItem.key]"
                                  @submit="submit" />
                </el-form-item>
            </template>
            <!-- 一行一个 -->
            <template v-else>
                <el-form-item :label="item.label"
                              :prop="spliceKey">
                    <span v-show="false">{{ setModel(spliceKey) }}</span>
                    <form-control :item="item"
                                  :model.sync="model[item.key]"
                                  @submit="submit" />
                </el-form-item>
            </template>
        </template>
    </div>
</template>
<script>
import FormControl from '@/common/components/FormControl'
export default {
    name: 'FormItem',
    components: {
        FormControl
    },
    props: {
        isGroup: {
            type: Boolean,
            default: false
        },
        spliceKey: {
            type: String,
            default: ''
        },
        rules: {
            type: Object,
            required: true
        },
        item: {
            type: Object,
            required: true
        },
        formData: {
            type: Object,
            required: true
        },
        formItem: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        model: null
    }),
    methods: {
        showWhen(enableWhen) {
            if (!enableWhen || !Object.keys(enableWhen)) return true
            for (const key in enableWhen) {
                if (this.getProperty(key) === enableWhen[key]) return true
            }
        },
        getStyle(item) {
            return {
                display: 'inline-block',
                width: item.width || '100%'
            }
        },
        getKey(item) {
            if (!this.spliceKey) return item.key
            else if (!item.key) return this.spliceKey
            return this.spliceKey + '.' + item.key
        },
        setModel(path) {
            const paths = path.split('.')
            let curProp = this.formData
            for (let i = 0; i < paths.length - 1; i++) {
                if (curProp[paths[i]] === undefined) return
                curProp = curProp[paths[i]]
            }
            this.model = curProp
        },
        getProperty(path) {
            const paths = path.split('.')
            let curProp = this.formData
            for (let i = 0; i < paths.length; i++) {
                if (curProp[paths[i]] === undefined) return
                curProp = curProp[paths[i]]
            }
            return curProp
        },
        submit() {
            this.$emit('submit')
        }
    }
}
</script>
<style lang="scss" scoped>
.el-form-item.hidden {
    visibility: hidden;
}
</style>
<style lang="scss">
.el-form-item .el-tabs__header.is-top {
    margin-left: 80px;
}
.el-divider__text {
    color: #606266;
}
</style>
