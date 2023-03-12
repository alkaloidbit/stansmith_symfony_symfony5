const Encore = require('@symfony/webpack-encore');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .configureDevServerOptions((options) => {
        options.clientLogLevel = 'silent';
    })
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')
    .addEntry('adminapp', './assets/js/adminapp.js')
    .addEntry('main', './assets/js/vue/index.js')
    .addEntry('admin', './assets/js/vue/admin/src/main.js')
    //.addEntry('page2', './assets/page2.js')

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    // .enableSingleRuntimeChunk()
    .disableSingleRuntimeChunk()

    // This is our alias to the root vue components directory
    .addAliases({
        '@': path.resolve(__dirname, 'assets/js', 'vue'),
        services: path.resolve(__dirname, 'assets/js', 'services'),
        styles: path.resolve(__dirname, 'assets', 'scss'),
        admin: path.resolve(__dirname, 'assets/js/vue/admin', 'src'),
    })
    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    .enableVueLoader((options) => {
        options.compilerOptions = {
            preserveWhitespace: false,
        };
    })

    .configureCssLoader((config) => {
        if (!Encore.isProduction() && config.modules) {
            config.modules.localIdentName = '[name]_[local]_[hash:base64:5]';
        }
    });
// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()

// uncomment if you use API Platform Admin (composer req api-admin)
// .enableReactPreset()
//.addEntry('admin', './assets/admin.js');

// if (!Encore.isProduction()) {
// Encore.disableCssExtraction();
// }

module.exports = Encore.getWebpackConfig();
