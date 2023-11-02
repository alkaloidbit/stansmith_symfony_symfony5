import Vue from "vue";
import Buefy from "buefy";
import _ from "lodash";
/* eslint-disable-next-line no-unused-vars */
import { Howl, Howler } from "howler";
/* eslint-disable-next-line no-unused-vars */

import App from "./App";
import router from "./router";
import store from "./store";

Vue.use(Buefy);
new Vue({
    components: { App },
    template: "<App/>",
    router,
    store,
}).$mount("#app");
