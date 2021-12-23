<template>
    <div class="trackListAlbumshowIndexRootContainer">
        <track-card
            v-for="(track, index) in tracks"
            :key="index + track['@id']"
            :track="track"
            @playlist-plus="playlistPlus(track)"
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
    },
    methods: {
        playTrackInPlaylist(track) {
            const selectedTrackIndex = this.playlist.findIndex((item) => item['@id'] === track['@id']);

            if (selectedTrackIndex !== -1) {
                if (this.currentTrack) {
                    if (this.currentTrack.howl) {
                        this.currentTrack.howl.stop();
                    }
                }
                this.play(selectedTrackIndex);
            }
        },
        playlistPlus(track) {
            console.log(track);
            this.$store.dispatch('playlist/addTrackToPlaylist', track);
            this.$buefy.snackbar.open(`Titre ${track.title} ajouté à la file d'attente.`);
        },
    },
};
</script>
