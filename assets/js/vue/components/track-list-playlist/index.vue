<template>
    <div class="trackListIndexRootContainer">
        <!-- <with-keyboard-control -->
        <!-- :list-length="tracks.length" -->
        <!-- @selected="selectedHandler" -->
        <!-- > -->
        <!-- <template slot-scope="{selectedIndex}"> -->
        <!-- 'key-selected': index === selectedIndex, -->
        <!-- :class="[{'current-track':  isCurrentTrack(track), -->
        <!-- :class="[{'current-track': track === currentTrack, -->
        <track-card
            v-for="(track, index) in tracks"
            :key="index + track['@id']"
            :track="track"
            class="trackCardRootContainer on-playlist playlist-item-renderer"
            :class="[{'current-track': isCurrentTrack(track),
                      'is-loading': track === currentTrack && isLoading,
                      'is-playing': track === currentTrack && isPlaying}]"
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
        console.log('this.tracks[0]', this.tracks[0]);
        console.log('this.tracks[1]', this.tracks[1]);
        /* eslint-disable no-undef */
        console.log('is track[0] equal track[1]?', _.isEqual(this.tracks[0], this.tracks[1]));
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

            console.log('on playTrack, selectedTrackIndex', selectedTrackIndex);

            if (this.currentTrack) {
                if (this.currentTrack.howl) {
                    this.currentTrack.howl.stop();
                }
            }

            this.play(selectedTrackIndex);
        },

        isCurrentTrack(track) {
            /* eslint-disable no-undef */
            return _.isEqual(track, this.currentTrack);
        },

        ES6diff(obj1, obj2) {
            return Object.entries(obj1).toString() === Object.entries(obj2).toString();
        },

        diff(obj1, obj2) {
            return this.isEquivalent(obj1, obj2);
        },

        isEquivalent(a, b) {
            // Create arrays of property names
            const aProps = Object.getOwnPropertyNames(a);
            const bProps = Object.getOwnPropertyNames(b);

            // If number of properties is different,
            // objects are not equivalent
            if (aProps.length !== bProps.length) {
                return false;
            }

            for (let i = 0; i < aProps.length; i += 1) {
                const propName = aProps[i];

                // If values of same property are not equal,
                // objects are not equivalent
                if (a[propName] !== b[propName]) {
                    return false;
                }
            }

            // If we made it this far, objects
            // are considered equivalent
            return true;
        },

    },
};
</script>
