<template>
    <div
        @click.prevent="handleClick(track)"
    >
        <div
            v-if="isCurrentTrack && isLoading"
            class="sk-chase"
        >
            <div class="sk-chase-dot" />
            <div class="sk-chase-dot" />
            <div class="sk-chase-dot" />
            <div class="sk-chase-dot" />
            <div class="sk-chase-dot" />
            <div class="sk-chase-dot" />
        </div>
        <div
            v-else
            class="left-item"
        >
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
        isCurrentTrack: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
        };
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
