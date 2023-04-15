<template>
    <div class="container is-fluid">
        <b-navbar>
            <template #brand>
                <b-navbar-item
                    tag="router-link"
                    :to="{ path: '/player' }"
                    class="navbar__brand"
                >
                    <img
                        :src="require('../../../../images/gnome-music.svg')"
                        alt="logo"
                    >
                    <!-- <strong class="navbar_title">StansMusic</strong> -->
                </b-navbar-item>
            </template>
            <template #start>
                <!-- <b-navbar-item href="#" /> -->
                <!-- <b-navbar-item href="#" /> -->
            </template>
            <template #end>
                <b-navbar-dropdown :label="user.username">
                    <b-navbar-item href="#">
                        Profile
                    </b-navbar-item>
                    <b-navbar-item href="#">
                        Contact
                    </b-navbar-item>
                </b-navbar-dropdown>
                <b-navbar-item tag="div">
                    <div class="buttons">
                        <b-button
                            v-if="isAuthenticated"
                            type="button is-primary is-outlined"
                            tag="a"
                            href="/api/security/logout"
                            icon-right="logout"
                        >
                            Logout
                        </b-button>
                    </div>
                </b-navbar-item>
            </template>
        </b-navbar>
    </div>
</template>

<script>
export default {
    name: 'Nav',
    props: {
        isAuthenticated: {
            type: Boolean,
            required: true,
        },
        user: {
            type: Object,
            required: false,
            default: null,
        },
    },
};
</script>

<style lang="scss" scoped>
nav {
    a {
        font-weight: bold;
        color: #2c3e50;
    }
}
.navbar-item img {
    max-height: 100%;
}

</style>
