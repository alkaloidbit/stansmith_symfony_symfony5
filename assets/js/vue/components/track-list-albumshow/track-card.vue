<template>
    <div
        class="trackCardAlbumshowRootContainer playlist-item-renderer"
        @click.prevent="handleClick(track)"
    >
        <div
            v-if="isCurrentTrack && isPlaying"
            class="sk-swing"
        >
            <div class="sk-swing-dot" />
            <div class="sk-swing-dot" />
        </div>
        <div
            v-else-if="isCurrentTrack && isLoading"
            class="sk-bounce"
        >
            <div class="sk-bounce-dot" />
            <div class="sk-bounce-dot" />
        </div>
        <div
            v-else-if="isCurrentTrack && isLoaded && !isPlaying"
            class="left-item"
        >
            <span
                class="play icon is-medium"
            >
                <i class="mdi mdi-24px mdi-play" />
            </span>
        </div>
        <div
            v-else
            class="left-item"
        >
            <span
                class="tracknumber"
            >{{ track.tracknumber }}</span>
        </div>
        <div class="middle-item title-wrapper">
            <span class="track-title">{{ track.title }}</span>
            <span>{{ track.artist.name }}</span>
        </div>
        <div class="duration right-item">
            {{ track.playtime_string }}
        </div>
    </div>
</template>

<script>
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'TrackCard',
    mixins: [playerMixin],
    props: {
        track: {
            type: Object,
            required: true,
        },
        isCurrentTrack: {
            type: Boolean,
            required: true,
        },
    },
    created() {
        console.log(this.isCurrentTrack);
    },
    methods: {
        handleClick(track) {
            this.$emit('clicked', track);
        },
    },
};
</script>
