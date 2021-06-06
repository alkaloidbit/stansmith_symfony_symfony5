<template>
    <div id="app">
        <nav-bar/>
            <aside-menu :menu="menu" @menu-click="menuClick"/>
                <router-view/>
                    <footer-bar/>
    </div>
</template>

<script>
// admin is an alias to /src
import axios from 'axios'
import NavBar from 'admin/components/NavBar'
import AsideMenu from 'admin/components/AsideMenu'
import FooterBar from 'admin/components/FooterBar'

export default {
    name: 'home',
    components: {
        FooterBar,
        AsideMenu,
        NavBar
    },
    computed: {
        menu () {
            return [
                'General',
                [
                    {
                        to: '/',
                        icon: 'desktop-mac',
                        label: 'Dashboard'
                    }
                ],
                'Examples',
                [
                    {
                        action: 'dark-mode-toggle',
                        label: 'Dark / White',
                        icon: 'weather-night'
                    },
                    {
                        to: '/mediaobjects',
                        label: 'MediaObjects',
                        icon: 'image',
                        updateMark: false
                    },
                    {
                        to: '/albums',
                        label: 'Albums',
                        icon: 'album',
                        updateMark: true
                    },
                    {
                        to: '/tables',
                        label: 'Tables',
                        icon: 'table',
                        updateMark: true
                    },
                    {
                        to: '/forms',
                        label: 'Forms',
                        icon: 'square-edit-outline'
                    },
                    {
                        to: '/profile',
                        label: 'Profile',
                        icon: 'account-circle'
                    },
                    {
                        label: 'Submenus',
                        subLabel: 'Submenus Example',
                        icon: 'view-list',
                        menu: [
                            {
                                href: '#void',
                                label: 'Sub-item One'
                            },
                            {
                                href: '#void',
                                label: 'Sub-item Two'
                            }
                        ]
                    }
                ],
                'About',
                [
                    {
                        href: 'https://admin-null.justboil.me',
                        label: 'Premium Demo',
                        icon: 'credit-card'
                    },
                    {
                        href: 'https://justboil.me/bulma-admin-template/null',
                        label: 'About',
                        icon: 'help-circle'
                    }
                ]
            ]
        }
    },
    created () {
        // Server response: isAuthenticated && User
        const isAuthenticated = JSON.parse(this.$parent.$el.attributes['data-is-authenticated'].value)
        // User from server
        const user = JSON.parse(this.$parent.$el.attributes['data-user'].value)

        if (isAuthenticated) {
            this.$store.commit('user', user)
        }

        const payload = { isAuthenticated, user }

        //  Updating states
        this.$store.dispatch('security/onRefresh', payload)

        axios.interceptors.request.use((req) => {
            console.log(`Request ${req.method} ${req.url}`)
            return req
        })

        axios.interceptors.response.use(
            (res) => res,
            (err) => {
                if (err.response.status === 401) {
                    if (this.$route.path !== '/login') {
                        this.$router.push({ path: '/login' })
                    }
                } else if (err.response.status === 500) {
                    document.open()
                    document.write(err.response.data)
                    document.close()
                }
                throw err
            }
        )
    },
    methods: {
        menuClick (item) {
            if (item.action && item.action === 'dark-mode-toggle') {
                this.$store.commit('darkModeToggle')
            }
        }
    }
}
</script>
