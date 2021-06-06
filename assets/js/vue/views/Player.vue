<template>
    <div class="PlayerRootContainer">
        <Nav
            :is-authenticated="isAuthenticated"
            :user="getUser"
        />
        <!-- <section class=""> -->
        <!-- Top level columns-container -->
        <!--<div class="columns"> -->
        <!-- <aside :class="asideClass">
                    <sidebar
                        :current-artist-id="currentArtistId"
                        :artists="artists"
                        :collapsed="sidebarCollapsed"
                        @toggle-collapsed="toggleSidebarCollapsed"
                    />
                </aside> -->
        <!-- .column -->
        <!-- <div :class="contentClass"> -->
        <component
            :is="currentComponent"
            v-bind="currentProps"
        />
        <!-- </div> -->
        <!-- </div> -->
        <!-- </section> -->
        <player
            :tracks="playlist"
            :prev-route="prevRoute"
            :is-playlist-active="isPlaylistActive"
        />
    </div>
</template>

<script>
import Nav from '@/components/partials/nav';
import Player from '@/components/player';
import Catalog from '@/components/catalog';
import Playlist from '@/components/playlist';
import Sidebar from '@/components/sidebar';
import AlbumShow from '@/components/album-show';
import { fetchArtists } from 'services/artists-service';
// import Sidebar from '../components/Sidebar';

export default {
    name: 'PlayerPage',
    components: {
        Nav,
        Player,
        Playlist,
        AlbumShow,
        Sidebar,
        Catalog,
    },
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            vm.prevRoute = from;
        });
    },
    props: {
        // Prop created by dynamic route
        artistID: {
            type: String,
            required: false,
            default: null,
        },
        albumID: {
            type: String,
            required: false,
            default: null,
        },
    },
    data() {
        return {
            sidebarCollapsed: false,
            artists: [],
            prevRoute: null,
        };
    },
    computed: {
        isPlaylistActive() {
            return this.$route.path === '/playlist';
        },
        playlist() {
            return this.$store.state.playlist.playlist;
        },
        isAuthenticated() {
            return this.$store.getters['security/isAuthenticated'];
        },
        getUser() {
            return this.$store.getters['security/getUser'];
        },
        asideClass() {
            return this.sidebarCollapsed ? 'aside-collapsed' : 'column is-one-fifth';
        },
        contentClass() {
            return this.sidebarCollapsed ? 'column ' : 'column ';
        },
        currentArtistId() {
            if (this.artistID === null) return null;
            return `/api/artists/${this.artistID}`;
        },
        currentAlbumId() {
            if (this.albumID === null) return null;
            return `/api/albums/${this.albumID}`;
        },
        currentComponent() {
            if (this.isPlaylistActive) {
                return Playlist;
            }
            return this.currentAlbumId !== null ? AlbumShow : Catalog;
        },
        currentProps() {
            if (this.isPlaylistActive) {
                return { playlist: this.playlist, prevRoute: this.prevRoute };
            }
            return this.currentComponent === AlbumShow ? {
                albumId: this.currentAlbumId,
            } : {
                currentArtistId: this.currentArtistId,
                artists: this.artists,
            };
        },
    },
    async created() {
        const { data } = await fetchArtists();
        this.artists = data['hydra:member'];
    },
    methods: {
        toggleSidebarCollapsed() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
        },
    },
};
</script>
