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
                    :class="[{'current-track': isCurrentTrack( index ),
                              'key-selected': index === selectedIndex,
                              'is-loading': isCurrentTrack( index ) && isLoading,
                              'is-playing': isCurrentTrack( index ) && isPlaying}]"
                    @clicked="selectedHandler(index)"
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
        selectedHandler(index) {
            this.playTrack(index);
        },

        playTrack(selectedTrackIndex) {
            if (this.currentTrack) {
                if (this.currentTrack.howl) {
                    this.currentTrack.howl.stop();
                }
            }

            this.play(selectedTrackIndex);
        },

        isCurrentTrack(index) {
            return index === this.currentIndex;
        },

    },
};
</script>
