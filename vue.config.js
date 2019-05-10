const CompressionPlugin = require('compression-webpack-plugin')
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
            filename: 'index.html'
        },
        query: {
            entry: 'src/pages/query/main.js',
            filename: 'query.html'
        }
    }
]
const config = {
    publicPath: isPord ? '../' : '/',
    pages: pages[isPord ? 1 : 0],
    lintOnSave: true,
    css: {
        loaderOptions: {
            sass: {
                data: `@import "@/common/styles/app.scss";`
            }
        }
    },
    configureWebpack: () => {
        if (isPord) {
            return {
                plugins: [
                    new CompressionPlugin({
                        test: /\.js$|\.html$|.\css/,
                        threshold: 10240,
                        deleteOriginalAssets: false
                    })
                ]
            }
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
module.exports = config
