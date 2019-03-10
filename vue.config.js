const CompressionPlugin = require("compression-webpack-plugin");
const isDev = process.env.NODE_ENV == 'development';
const current = 'admin';
const pages = [
  // development
  // 只能调试一个
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
      definitions[0]['process.env']['APP_NAME'] = JSON.stringify(require('./package.json').name);
      definitions[0]['process.env']['APP_TITLE'] = JSON.stringify(require('./package.json').title);
      definitions[0]['process.env']['APP_VERSION'] = JSON.stringify(require('./package.json').version);
      return definitions;
    });
  }
};
module.exports = config;