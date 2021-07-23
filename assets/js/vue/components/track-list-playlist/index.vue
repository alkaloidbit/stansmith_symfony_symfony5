<template>
    <div class="trackListIndexRootContainer">
        <!-- <with-keyboard-control -->
        <!-- :list-length="tracks.length" -->
        <!-- @selected="selectedHandler" -->
        <!-- > -->
        <!-- <template slot-scope="{selectedIndex}"> -->
        <!-- 'key-selected': index === selectedIndex, -->
        <track-card
            v-for="(track, index) in tracks"
            :key="index + track['@id']"
            :track="track"
            @clicked="clickedHandler(track)"
        />
        <!-- </template> -->
        <!-- </with-keyboard-control> -->
    </div>
</template>

<script>
import TrackCard from '@/components/track-list-playlist/track-card';
// import WithKeyboardControl from '@/components/WithKeyboardControl';
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'TrackListPlaylist',
    components: {
        TrackCard,
        // WithKeyboardControl,
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
        console.log('index.vue in track-list-playlist.vue');
    },
    methods: {
        selectTrack(track) {
            console.log(track);
            this.selectedTrack = track;
        },
        selectedHandler(index) {
            console.log('on selectedHandler, index:', index);
            this.playTrack(this.tracks[index]);
        },
        clickedHandler(track) {
            this.playTrack(track);
        },
        addTrackToPlaylist(track) {
            this.$store.dispatch('playlist/addTrackToPlaylist', track);
            console.log(this.playlist);
        },
        // on Click on playlist track list
        playTrack(track) {
            // component local selectedTrack
            this.selectTrack(track);

            // finding selectedTrack index inside tracks prop
            const selectedTrackIndex = this.tracks.findIndex((item) => item === this.selectedTrack);

            console.log('on playTrack, selectedTrackIndex', selectedTrackIndex);

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
