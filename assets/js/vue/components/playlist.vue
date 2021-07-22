<template>
    <div
        v-if="playlist.length"
        class="PlaylistRootContainer column"
    >
        <b-button
            icon-right="delete"
            type="is-primary"
            size="is-medium"
            @click="clearPlaylist"
        />
        <track-list
            :tracks="playlist"
            on-playlist
        />
    </div>
</template>

<script>
import TrackList from '@/components/track-list';

export default {
    name: 'Playlist',
    components: {
        TrackList,
    },
    props: {
        playlist: {
            type: Array,
            required: false,
            default: () => {},
        },
        prevRoute: {
            type: Object,
            required: false,
            default: () => {},
        },
    },
    methods: {
        clearPlaylist() {
            this.$store.dispatch('playlist/initPlaylist');
        },
    },
};
</script>
