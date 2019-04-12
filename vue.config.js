const CompressionPlugin = require("compression-webpack-plugin");
const pkg = require('./package.json')
const isDev = process.env.NODE_ENV == 'development';
const current = 'admin';
const pages = [
  // development
  // can only debug one
  {
    index: {
      entry: `src/pages/${current}/main.js`,
      filename: 'index.html',
    },
  },
  // production
  {
    index: {
      entry: 'src/pages/admin/main.js',
      filename: 'index.html',
    },
  }
];
const config = {
  publicPath: isDev ? '/' : './',
  pages: pages[isDev ? 0 : 1],
  lintOnSave: false,
  css: {
    loaderOptions: {
      sass: {
        data: `@import "@/common/styles/app.scss";`
      }
    }
  },
  configureWebpack: () => {
    if (!isDev) {
      return {
        plugins: [
          new CompressionPlugin({
            test: /\.js$|\.html$|.\css/,
            threshold: 10240,
            deleteOriginalAssets: false
          }),
        ]
      }
    }
  },
  chainWebpack: (config) => {
    config.plugin('define').tap((definitions) => {
      definitions[0]['process.env']['APP_NAME'] = JSON.stringify(pkg.name)
      definitions[0]['process.env']['APP_TITLE'] = JSON.stringify(pkg.title)
      definitions[0]['process.env']['APP_VERSION'] = JSON.stringify(pkg.version)
      return definitions;
    });
  }
};
module.exports = config;