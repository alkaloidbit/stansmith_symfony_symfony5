<template>
    <div
        class="trackCardAlbumshowRootContainer playlist-item-renderer"
        @click.prevent="handleClick(track)"
    >
        <div class="left-item">
            <span
                class="tracknumber"
            >{{ track.tracknumber }}</span>
            <span class="sound-bars" />
        </div>
        <div class="middle-item title-wrapper">
            <span>{{ track.title }}</span>
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
    },
    created() {
        console.log('created tracklistalbumshow trackcard');
    },
    methods: {
        handleClick(track) {
            this.$emit('clicked', track);
        },
    },
};
</script>
