/* Styles */
import 'admin/scss/main.scss'

/* Core */
import Vue from 'vue'
import Buefy from 'buefy'
// import moment from 'moment'
import dayjs from 'dayjs'
// import fr from 'dayjs/locale/fr'
import relativeTime from 'dayjs/plugin/relativeTime'

/* Router & Store */
import router from './router'
import store from './store'

/* Service Worker */
import './registerServiceWorker'

/* Vue. Main component */
import App from './App.vue'

// dayjs.locale('en')
dayjs.extend(relativeTime)
Vue.filter('formatDate', function (value) {
    if (value) {
        return dayjs().to(dayjs(value))
        // return dayjs(String(value)).format('MMM D, YYYY')
    }
})

/* Default title tag */
const defaultDocumentTitle = 'Admin Null Bulma'

/* Collapse mobile aside menu on route change & set document title from route meta */
router.afterEach(to => {
    store.commit('asideMobileStateToggle', false)

    if (to.meta.title) {
        document.title = `${to.meta.title} — ${defaultDocumentTitle}`
    } else {
        document.title = defaultDocumentTitle
    }

    if (to.name === 'login') {
        store.commit('navBarVisibleToggle', false)
        store.commit('asideVisibleToggle', false)
        store.commit('footerBarVisibleToggle', false)
    } else {
        store.commit('navBarVisibleToggle', true)
        store.commit('asideVisibleToggle', true)
        store.commit('footerBarVisibleToggle', true)
    }
})

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (store.getters['security/isAuthenticated']) {
            next()
        } else {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            })
        }
    } else {
        next()
    }
})

Vue.config.productionTip = false
Vue.use(Buefy)

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#admin_app')
