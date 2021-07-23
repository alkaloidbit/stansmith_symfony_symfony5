<template>
    <div class="trackListAlbumshowIndexRootContainer">
        <track-card
            v-for="(track, index) in tracks"
            :key="index + track['@id']"
            :track="track"
            @clicked="clickedHandler(track)"
        />
    </div>
</template>

<script>
import TrackCard from '@/components/track-list-albumshow/track-card';
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'TrackListAlbumshow',
    components: {
        TrackCard,
    },
    mixins: [playerMixin],
    props: {
        tracks: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {};
    },
    created() {
        console.log('created tracklistalbumshow index');
    },
    methods: {
        clickedHandler(track) {
            this.addTrackToPlaylist(track);
        },
        addTrackToPlaylist(track) {
            this.$store.dispatch('playlist/addTrackToPlaylist', track);
            console.log(this.playlist);
        },
    },
};
</script>
