<template>
    <div class="trackListIndexRootContainer">
        <with-keyboard-control
            :list-length="tracks.length"
            @selected="selectedHandler"
        >
            <template slot-scope="{selectedIndex}">
                <track-card
                    v-for="(track, index) in tracks"
                    :key="index + track['@id']"
                    :track="track"
                    class="trackCardRootContainer on-playlist playlist-item-renderer"
                    :class="[{'current-track': isCurrentTrack(track, index ),
                              'key-selected': index === selectedIndex,
                              'is-loading': track === currentTrack && isLoading,
                              'is-playing': track === currentTrack && isPlaying}]"
                    @clicked="clickedHandler(track)"
                />
            </template>
        </with-keyboard-control>
    </div>
</template>

<script>
import TrackCard from '@/components/track-list-playlist/track-card';
import WithKeyboardControl from '@/components/WithKeyboardControl';
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'TrackListPlaylist',
    components: {
        TrackCard,
        WithKeyboardControl,
    },
    mixins: [playerMixin],
    props: {
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
    created() {
    },
    methods: {
        clickedHandler(track) {
            this.playTrack(track);
        },

        selectedHandler(index) {
            this.playTrack(this.tracks[index]);
        },

        // on Click on playlist track list
        playTrack(track) {
            // finding selectedTrack index inside tracks prop
            const selectedTrackIndex = this.tracks.findIndex((item) => item === track);

            if (this.currentTrack) {
                if (this.currentTrack.howl) {
                    this.currentTrack.howl.stop();
                }
            }

            this.play(selectedTrackIndex);
        },

        isCurrentTrack(track, index) {
            return index === this.currentIndex;
        },

    },
};
</script>
