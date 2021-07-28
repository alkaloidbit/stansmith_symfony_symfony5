<template>
    <div
        v-if="playlist.length"
        class="playlistRootContainer column"
    >
        <b-button
            icon-right="delete"
            type="is-primary"
            size="is-medium"
            @click="clearPlaylist"
        />
        <track-list-playlist
            :tracks="playlist"
        />
    </div>
</template>

<script>
import TrackListPlaylist from '@/components/track-list-playlist';

export default {
    name: 'Playlist',
    components: {
        TrackListPlaylist,
    },
    props: {
        prevRoute: {
            type: Object,
            required: false,
            default: () => {},
        },
    },
    computed: {
        playlist() {
            return this.$store.state.playlist.playlist;
        },
    },
    methods: {
        clearPlaylist() {
            this.$store.dispatch('playlist/initPlaylist');
        },
    },
};
</script>
