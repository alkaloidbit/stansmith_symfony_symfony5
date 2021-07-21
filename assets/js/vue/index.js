// webpackEntryConfig('main')
import Vue from 'vue';
import Buefy from 'buefy';
/* eslint-disable-next-line no-unused-vars */
import { Howl, Howler } from 'howler';
/* eslint-disable-next-line no-unused-vars */
import _ from 'lodash';
import VueLazyload from 'vue-lazyload';
import VuePageTransition from 'vue-page-transition';
import App from './App';
import router from './router';
import store from './store';

import loadingGif from '../../images/loading.gif';

Vue.use(Buefy);
Vue.use(VueLazyload, {
    silent: false,
    loading: loadingGif,
    attempt: 1,
});

Vue.use(VuePageTransition);

Vue.filter('minutes', (value) => {
    if (!value || typeof value !== 'number') return '00:00';
    let min = parseInt(value / 60, 10);
    let sec = parseInt(value % 60, 10);
    min = min < 10 ? `0${min}` : min;
    sec = sec < 10 ? `0${sec}` : sec;
    value = `${min}:${sec}`;
    return value;
});

Vue.config.productionTip = false;

new Vue({
    components: { App },
    template: '<App/>',
    router,
    store,
}).$mount('#app');
