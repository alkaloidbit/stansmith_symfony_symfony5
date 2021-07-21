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
                    :class="[{selected: track === currentTrack,
                              'key-selected': index === selectedIndex,
                              'on-playlist': onPlaylist,
                              'is-loading': track === currentTrack && isLoading,
                              'is-playing': track === currentTrack && isPlaying}]"
                    :on-playlist="onPlaylist"
                    @playTrack="playTrack(track)"
                />
            </template>
        </with-keyboard-control>
    </div>
</template>

<script>
import TrackCard from '@/components/track-list/track-card';
import WithKeyboardControl from '@/components/WithKeyboardControl';
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'TrackList',
    components: {
        TrackCard,
        WithKeyboardControl,
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
        selectedHandler(index) {
            console.log('index: ', index);
            this.playTrack(this.tracks[index]);
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

            this.play(selectedTrackIndex);
        },

    },
};
</script>
