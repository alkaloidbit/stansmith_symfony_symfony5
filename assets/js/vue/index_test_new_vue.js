import Vue from 'vue';

import AppAlt from './AppAlt';
console.log('Hello world!');

new Vue({
    components: {AppAlt},
    template: '<AppAlt/>',
}).$mount('#app');
