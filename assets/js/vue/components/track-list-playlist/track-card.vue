<template>
    <div
        class="trackCardRootContainer on-playlist playlist-item-renderer"
        :class="[{'current-track': track === currentTrack,
                  'is-loading': track === currentTrack && isLoading,
                  'is-playing': track === currentTrack && isPlaying}]"
        @click.prevent="handleClick(track)"
    >
        <div class="left-item">
            <span
                class="tracknumber"
            >{{ track.tracknumber }}</span>
            <span
                v-if="!isLoading "
                class="play icon is-medium"
            >
                <i class="mdi mdi-24px mdi-play" />
            </span>
            <img
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
    },
    created() {
    },
    methods: {
        handleClick(track) {
            this.$emit('clicked', track);
        },
    },
};
</script>
