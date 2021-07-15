<template>
    <div
        class="trackCardRootContainer playlist-item-renderer"
        @click.prevent="handleClick(track)"
    >
        <div class="left-item">
            <span
                v-if="!onPlaylist"
                class="tracknumber"
            >{{ track.tracknumber }}</span>
            <span
                v-if="!isLoading && onPlaylist"
                class="play icon is-medium">
                <i class="mdi mdi-24px mdi-play" />
            </span>
            <img
                v-if="onPlaylist "
                :src="track.thumbnail.contentUrl"
                alt=""
            >
            <span class="sound-bars" />
        </div>
        <div class="middle-item title-wrapper">
            <span>{{ track.title }}</span>
            <span>{{ track.artist.name }}</span>
        </div>
        <div
            v-if="onPlaylist"
            class="middle-item title-wrapper"
        >
            {{ track.album }}
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
        onPlaylist: {
            type: Boolean,
            required: true,
            default: false,
        },
    },
    data() {
        return {};
    },
    computed: {
    },
    created() {
    },
    methods: {
        handleClick(track) {
            if (this.onPlaylist) {
                this.$emit('playTrack', track);
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
