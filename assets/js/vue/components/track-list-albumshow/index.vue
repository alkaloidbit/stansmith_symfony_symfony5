<template>
    <div class="trackListAlbumshowIndexRootContainer">
        <track-card
            v-for="(track, index) in tracks"
            :key="index + track['@id']"
            :track="track"
            :is-current-track="isCurrentTrack(track)"
            :class="[{'current-track': isCurrentTrack( track ),
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
            if (this.currentTrack) {
                return track['@id'] === this.currentTrack['@id'];
            }
            return false;
        },

        clickedHandler(track) {
            const selectedTrackIndex = this.playlist.findIndex((item) => item['@id'] === track['@id']);

            if (selectedTrackIndex !== -1) {
                if (this.currentTrack) {
                    if (this.currentTrack.howl) {
                        this.currentTrack.howl.stop();
                    }
                }
                this.play(selectedTrackIndex);
            } else {
                this.addTrackToPlaylist(track);
            }
        },

        addTrackToPlaylist(track) {
            this.$store.dispatch('playlist/addTrackToPlaylist', track);
        },

    },
};
</script>
