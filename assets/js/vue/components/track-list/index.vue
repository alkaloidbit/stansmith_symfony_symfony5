<template>
    <div class="trackListIndexRootContainer">
        <track-card
            v-for="(track, index) in tracks"
            :key="index + track['@id']"
            :track="track"
            :class="[{selected: track === currentTrack, 'is-playing': isPlaying}]"
            :on-playlist="onPlaylist"
            @playTrack="playTrack(track)"
        />
    </div>
</template>

<script>
import TrackCard from '@/components/track-list/track-card';
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'TrackList',
    components: {
        TrackCard,
    },
    mixins: [playerMixin],
    props: {
        onPlaylist: {
            type: Boolean,
            required: true,
            default: false,
        },
        tracks: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            selectedTrack: null,
        };
    },
    methods: {
        selectTrack(track) {
            this.selectedTrack = track;
        },
        // on Click on playlist track list
        playTrack(track) {
            // component local selectedTrack
            this.selectTrack(track);
            // finding selectedTrack index inside tracks prop
            const selectedTrackIndex = this.tracks.findIndex((item) => item === this.selectedTrack);

            if (this.currentTrack) {
                if (this.currentTrack.howl) {
                    this.currentTrack.howl.stop();
                }
            }

            this.$store.dispatch('currentIndex/setCurrentIndex', selectedTrackIndex, { root: true });

            this.play(selectedTrackIndex);
        },

    },
};
</script>
