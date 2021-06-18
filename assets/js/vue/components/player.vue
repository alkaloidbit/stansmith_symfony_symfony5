<template>
    <section>
        <div
            class="container is-fluid progress-bar"
            @click="seek( $event )"
        >
            <div
                id="progress"
                :style="{ width: progressWidth + '%' }"
            />
            <!--<div
                id="progress-knob"
                :style="{ left: progressWidth + '%' }"
                />-->
        </div>
        <div class="container is-fluid player-bar">
            <div class="columns">
                <div class="column is-one-third is-flex is-align-items-center">
                    <play-button-player
                        :is-playing="isPlaying"
                        @play="play"
                        @pause="pause"
                        @skip="skip"
                    />
                    <div
                        v-if="currentTrack !== undefined"
                        class="is-flex time-info-wrapper is-align-items-center"
                    >
                        <span class="time-info">{{ getCurrentTrackTiming.seekTimer | minutes }} /
                            {{ getCurrentTrackTiming.duration | minutes }}</span>
                    </div>
                </div>
                <div
                    class="column is-one-third
                    is-flex is-align-items-center is-justify-content-center"
                    :class="isLoading ? 'is-loading' : ''"
                >
                    <img
                        v-if="currentTrack !== undefined"
                        :src="getCurrentTrackInfo.thumbnail.contentUrl"
                    >
                    <div
                        v-if="currentTrack !== undefined"
                        class="content-info-wrapper"
                    >
                        <strong>{{ getCurrentTrackInfo.title }}</strong>
                        <p>{{ getCurrentTrackInfo.artist }} - {{ getCurrentTrackInfo.album }}</p>
                    </div>
                </div>
                <div
                    class="column is-one-third
                    is-flex is-align-items-center
                    is-justify-content-space-between"
                >
                    <volume-control />
                    <repeat-control />
                    <b-button
                        v-if="isPlaylistActive"
                        tag="router-link"
                        :to="prevRoute.path"
                        icon-right="menu"
                        type="is-primary"
                        size="is-medium"
                    />
                    <b-button
                        v-else
                        tag="router-link"
                        to="/playlist"
                        icon-right="menu"
                        type="is-primary"
                        size="is-medium"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import VolumeControl from '@/components/VolumeControl';
import RepeatControl from '@/components/RepeatControl';
import PlayButtonPlayer from '@/components/PlayButtonPlayer';
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'Player',
    components: {
        VolumeControl,
        RepeatControl,
        PlayButtonPlayer,
    },
    mixins: [playerMixin],
    props: {
        tracks: {
            type: Array,
            required: false,
            default: () => [],
        },
        isPlaylistActive: {
            type: Boolean,
            required: true,
            default: false,
        },
        prevRoute: {
            type: Object,
            required: false,
            default: () => {},
        },
    },
    data() {
        return {
            seekTimer: 0,
            progressWidth: 0,
        };
    },
    computed: {
        getCurrentTrackInfo() {
            if (this.currentTrack) {
                const artist = this.currentTrack.artist.name;
                const { title } = this.currentTrack;
                const { thumbnail } = this.currentTrack;
                const { album } = this.currentTrack;
                return {
                    artist,
                    album,
                    title,
                    thumbnail,
                };
            }
            return null;
        },
        getCurrentTrackTiming() {
            if (this.currentTrack) {
                return {
                    seekTimer: this.seekTimer,
                    duration: this.duration,
                };
            }
            return null;
        },
    },
    watch: {
        // We watch the Player's playing property
        // and update the seek property 4 times a sec
        isPlaying(isPlaying) {
            this.seekTimer = this.currentTrack.howl.seek();
            let updateSeek;
            if (isPlaying) {
                updateSeek = setInterval(() => {
                    this.seekTimer = this.currentTrack.howl.seek();
                    this.progressWidth = (((this.seekTimer / this.duration) * 100) || 0);
                }, 250);
            } else {
                clearInterval(updateSeek);
            }
        },
    },
    created() {
        // console.log(this.currentTrack);
    },
    methods: {
        seek(event) {
            const sound = this.currentTrack.howl;

            const per = event.clientX / window.innerWidth;
            const duration = sound.duration();

            sound.seek(per * duration);
        },
    },
};
</script>

<style lang="scss">
.player-bar {
    position: fixed;
    bottom: 0;
    // border-top: 1px solid $grey-lighter;
    background-color: #FFF;
    padding-top: 20px;
    padding-bottom: 20px;
}

.time-info-wrapper {
    margin-left: 15px;
}

.time-info {
    margin: 0 16px 0 12px;
    white-space: nowrap;
}
</style>
