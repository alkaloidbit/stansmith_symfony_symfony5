import Vue from 'vue'
import Vuex from 'vuex'
import SecurityModule from '../../../store/security'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        security: SecurityModule
    },
    state: {
        /* User */
        userName: null,
        userEmail: null,
        userAvatar: null,

        albumTitle: null,
        albumCover: null,
        albumArtist: null,

        cover: null,

        /* NavBar */
        isNavBarVisible: true,

        /* FooterBar */
        isFooterBarVisible: true,

        /* Aside */
        isAsideVisible: true,
        isAsideMobileExpanded: false,

        /* Dark mode */
        isDarkModeActive: false
    },
    mutations: {
        /* A fit-them-all commit */
        basic (state, payload) {
            state[payload.key] = payload.value
        },

        album (state, payload) {
            if (payload.title) {
                state.albumTitle = payload.title
            }

            if (payload.artist) {
                state.albumArtist = payload.artist.name
            }

            if (payload.cover) {
                state.albumCover = payload.cover.contentUrl
            }
        },
        cover (state, payload) {
            state.cover = payload
        },
        /* User */
        user (state, payload) {
            if (payload.username) {
                state.userName = payload.username
            }
            if (payload.email) {
                state.userEmail = payload.email
            }
            if (payload.avatar) {
                state.userAvatar = payload.avatar
            }
        },

        /* Aside Mobile */
        asideMobileStateToggle (state, payload = null) {
            const htmlClassName = 'has-aside-mobile-expanded'

            let isShow

            if (payload !== null) {
                isShow = payload
            } else {
                isShow = !state.isAsideMobileExpanded
            }

            if (isShow) {
                document.documentElement.classList.add(htmlClassName)
            } else {
                document.documentElement.classList.remove(htmlClassName)
            }

            state.isAsideMobileExpanded = isShow
        },

        /* Dark Mode */
        darkModeToggle (state, payload = null) {
            const htmlClassName = 'is-dark-mode-active'

            state.isDarkModeActive = !state.isDarkModeActive

            if (state.isDarkModeActive) {
                document.documentElement.classList.add(htmlClassName)
            } else {
                document.documentElement.classList.remove(htmlClassName)
            }
        },

        navBarVisibleToggle (state, payload = null) {
            let isShow

            if (payload !== null) {
                isShow = payload
            } else {
                isShow = !state.isNavBarVisible
            }
            state.isNavBarVisible = isShow
        },

        asideVisibleToggle (state, payload = null) {
            let isShow

            if (payload !== null) {
                isShow = payload
            } else {
                isShow = !state.isAsideVisible
            }
            state.isAsideVisible = isShow
        },

        footerBarVisibleToggle (state, payload = null) {
            let isShow

            if (payload !== null) {
                isShow = payload
            } else {
                isShow = !state.isFooterBarVisible
            }
            state.isFooterBarVisible = isShow
        }
    },
    actions: {

    }
})
