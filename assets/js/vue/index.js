// webpackEntryConfig('main')
import Vue from 'vue';
import Buefy from 'buefy';
/* import 'buefy/dist/buefy.css'; */

// import { stringify } from 'flatted';
/* eslint-disable-next-line no-unused-vars */
import { Howl, Howler } from 'howler';

/* eslint-disable-next-line no-unused-vars */
import _ from 'lodash';

import VueLazyload from 'vue-lazyload';
import App from './App';
import router from './router';
import store from './store';

Vue.use(Buefy);
Vue.use(VueLazyload);

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
