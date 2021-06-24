<template>
    <section>
        <div
            class="container is-fluid progress-bar"
            @click="seek( $event )"
            @mouseover="seek($event, hover = true)"
            @mouseleave="seek($event, hover = false)"
        >
            <div class="progress-container">
                <div class="bar-container">
                    <div
                        id="progress"
                        :style="{ width: progressWidth + '%' }"
                    />
                </div>
            </div>
            <span
                class="hover-time-info"
                :style="{left:tooltipPosition+'px'}"
            >{{ seekPosition }}</span>
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
                        v-if="currentTrack !== undefined && !isLoading"
                        :src="getCurrentTrackInfo.thumbnail.contentUrl"
                    >
                    <div
                        v-if="currentTrack !== undefined && !isLoading"
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
            hover: false,
            seekTimer: 0,
            seekPosition: 0,
            tooltipPosition: 0,
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
        seek(event, hover = false) {
            if (this.currentTrack) {
                const sound = this.currentTrack.howl;
                const per = event.clientX / window.innerWidth;
                const duration = sound.duration();
                if (event.type === 'click') {
                    sound.seek(per * duration);
                }

                if (hover) {
                    console.log(this.formatTime(per * duration));
                    this.seekPosition = this.formatTime(per * duration);
                    this.tooltipPosition = event.clientX;
                }
            }
        },

        formatTime(value) {
            if (!value || typeof value !== 'number') return '00:00';
            let min = parseInt(value / 60, 10);
            let sec = parseInt(value % 60, 10);
            min = min < 10 ? `0${min}` : min;
            sec = sec < 10 ? `0${sec}` : sec;
            value = `${min}:${sec}`;
            return value;
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
    // padding-top: 20px;
    padding-bottom: 20px;
}

.time-info-wrapper {
    margin-left: 15px;
}

.time-info {
    margin: 0 16px 0 12px;
    font-size: .875rem;
    white-space: nowrap;
}
</style>
