const CompressionPlugin = require('compression-webpack-plugin')
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer')
    .BundleAnalyzerPlugin
const pkg = require('./package.json')
const isPord = process.env.NODE_ENV === 'production'
const current = 'admin'
const pages = [
    // development
    // can only debug one
    {
        index: {
            entry: `src/pages/${current}/main.js`,
            filename: 'index.html'
        }
    },
    // production
    {
        index: {
            entry: 'src/pages/admin/main.js',
            filename: 'admin/index.html'
        },
        query: {
            entry: 'src/pages/query/main.js',
            filename: 'query/index.html'
        }
    }
]
module.exports = {
    publicPath: isPord ? '../' : '/',
    pages: pages[isPord ? 1 : 0],
    lintOnSave: !isPord,
    productionSourceMap: false,
    css: {
        extract: true,
        sourceMap: false,
        loaderOptions: {
            sass: {
                data: `@import "@/common/styles/app.scss";`
            }
        }
    },
    devServer: {
        host: '0.0.0.0',
        port: 8080,
        https: false,
        open: true,
        hotOnly: true
    },
    configureWebpack: config => {
        const pluginsPro = [
            new CompressionPlugin({
                test: /\.js$|\.html$|.\css/,
                threshold: 10240,
                deleteOriginalAssets: false
            })
        ]
        if (process.env.npm_config_report) {
            pluginsPro.push(new BundleAnalyzerPlugin())
        }
        const pluginsDev = []
        if (isPord) {
            config.plugins = [...config.plugins, ...pluginsPro]
        } else {
            config.plugins = [...config.plugins, ...pluginsDev]
        }
    },
    chainWebpack: config => {
        config.plugin('define').tap(definitions => {
            definitions[0]['process.env']['APP_NAME'] = JSON.stringify(pkg.name)
            definitions[0]['process.env']['APP_TITLE'] = JSON.stringify(
                pkg.title
            )
            definitions[0]['process.env']['APP_VERSION'] = JSON.stringify(
                pkg.version
            )
            return definitions
        })
    }
}
