import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';
// import Home from '../views/Home';
import Player from '../views/Player';
import Login from '../views/Login';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        // { path: '/home', component: Home },
        { path: '/login', component: Login },
        { path: '/admin/:entitytype' },
        {
            path: '/playlist',
            component: Player,
            meta: { requiresAuth: true },
        },
        {
            path: '/player',
            component: Player,
            meta: { requiresAuth: true },
        },
        {
            path: '/artist/:artistID',
            component: Player,
            props: true,
            meta: { requiresAuth: true },
        },
        {
            path: '/album/:albumID',
            component: Player,
            props: true,
            meta: { requiresAuth: true },
        },
        { path: '*', redirect: '/player' },
    ],
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (store.getters['security/isAuthenticated']) {
            next();
        } else {
            next({
                path: '/login',
                query: { redirect: to.fullPath },
            });
        }
    } else {
        next(); // make sure to always call next()!
    }
});

export default router;
