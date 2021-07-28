<template>
    <div class="trackListAlbumshowIndexRootContainer">
        <track-card
            v-for="(track, index) in tracks"
            :key="index + track['@id']"
            :track="track"
            :is-current-track="isCurrentTrack(track)"
            :class="[{'current-track': isCurrentTrack( track ),
                      'paused': isCurrentTrack( track ) && !isPlaying && isLoaded,
                      'is-playing': isCurrentTrack( track ) && isPlaying}]"
            @clicked="clickedHandler(track)"
        />
    </div>
</template>

<script>
import TrackCard from '@/components/track-list-albumshow/track-card';
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'TrackListAlbumshow',
    components: {
        TrackCard,
    },
    mixins: [playerMixin],
    props: {
        tracks: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {};
    },
    created() {
    },
    methods: {
        isCurrentTrack(track) {
            return track['@id'] === this.currentTrack['@id'];
        },
        clickedHandler(track) {
            this.addTrackToPlaylist(track);
        },
        addTrackToPlaylist(track) {
            this.$store.dispatch('playlist/addTrackToPlaylist', track);
        },
    },
};
</script>
