import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../../../views/Login'

Vue.use(VueRouter)

const routes = [
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        // Document title tag
        // We combine it with defaultDocumentTitle set in `src/main.js` on router.afterEach hook
        meta: {
            title: 'Dashboard',
            requiresAuth: true
        },
        path: '/',
        name: 'home',
        component: Home
    },
    {
        meta: {
            title: 'Tables',
            requiresAuth: true
        },
        path: '/tables',
        name: 'tables',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "tables" */ '../views/Tables.vue')
    },
    {
        meta: {
            title: 'Albums',
            requiresAuth: true
        },
        path: '/albums',
        name: 'albums',
        component: () => import('../views/Albums.vue')
    },
    {
        meta: {
            title: 'Media Objects',
            requiresAuth: true
        },
        path: '/mediaobjects',
        name: 'mediaObjects',
        component: () => import('../views/MediaObjects.vue')
    },
    {
        meta: {
            title: 'Forms',
            requiresAuth: true
        },
        path: '/forms',
        name: 'forms',
        component: () => import(/* webpackChunkName: "forms" */ '../views/Forms.vue')
    },
    {
        meta: {
            title: 'Profile',
            requiresAuth: true
        },
        path: '/profile',
        name: 'profile',
        component: () => import(/* webpackChunkName: "profile" */ '../views/Profile.vue')
    },
    {
        meta: {
            title: 'New Media Object',
            requiresAuth: true
        },
        path: '/media_object/new',
        name: 'media_object.new',
        component: () => import(/* webpackChunkName: "client-form" */ '../views/MediaObjectForm.vue')
    },
    {
        meta: {
            title: 'Edit Media Object',
            requiresAuth: true
        },
        path: '/media_object/:id',
        name: 'media_object.edit',
        component: () => import(/* webpackChunkName: "client-form" */ '../views/MediaObjectForm.vue'),
        props: true
    },
    {
        meta: {
            title: 'New Album',
            requiresAuth: true
        },
        path: '/album/new',
        name: 'album.new',
        component: () => import(/* webpackChunkName: "client-form" */ '../views/AlbumForm.vue')
    },
    {
        meta: {
            title: 'Edit album',
            requiresAuth: true
        },
        path: '/album/:id',
        name: 'album.edit',
        component: () => import(/* webpackChunkName: "client-form" */ '../views/AlbumForm.vue'),
        props: true
    },
    {
        meta: {
            title: 'New client',
            requiresAuth: true
        },
        path: '/client/new',
        name: 'client.new',
        component: () => import(/* webpackChunkName: "client-form" */ '../views/ClientForm.vue')
    },
    {
        meta: {
            title: 'Edit client',
            requiresAuth: true
        },
        path: '/client/:id',
        name: 'client.edit',
        component: () => import(/* webpackChunkName: "client-form" */ '../views/ClientForm.vue'),
        props: true
    },
    {
        path: '*', redirect: '/admin/'
    }
]

const router = new VueRouter({
    mode: 'history',
    // base: process.env.BASE_URL,
    base: '/admin/',
    routes,
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }
})

export default router
