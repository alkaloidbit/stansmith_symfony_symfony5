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
            :current-track="currentTrack"
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
    data() {
        return {};
    },
    computed: {
        currentTrack() {
            return this.$store.getters['playlist/currentTrack'];
        },
    },
    created() {
    },
    methods: {
        clearPlaylist() {
            this.$store.dispatch('playlist/initPlaylist');
        },
    },
};
</script>
