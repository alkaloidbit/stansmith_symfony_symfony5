// vue.config.js
module.exports = {
    css: {
        loaderOptions: {
            sass: {
                prependData: '`@import "~/bulma/sass/utilities/_all";'
            },
        },
    },
};
