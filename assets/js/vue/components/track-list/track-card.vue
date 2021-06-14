<template>
    <div
        class="trackCardRootContainer playlist-item-renderer"
        @click.prevent="handleClick(track)"
    >
        <div class="left-item">
            <span class="tracknumber">{{ track.tracknumber }}</span>
            <span class="icon is-medium">
                <i class="mdi mdi-24px mdi-play" />
            </span>
            <img
                :src="track.thumbnail.contentUrl"
                alt=""
            >
            <span class="sound-bars" />
        </div>
        <div class="middle-item title-wrapper">
            {{ track.title }}
        </div>
        <div class="duration right-item">
            {{ track.playtime_string }}
        </div>
    </div>
</template>

<script>

export default {
    name: 'TrackCard',
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
