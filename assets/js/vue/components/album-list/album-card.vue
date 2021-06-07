<template>
    <div class="albumListalbumCardRootContainer column is-third">
        <div :class="$style['album-box']">
            <div
                :class="$style.image"
                class="is-album-cover"
            >
                <router-link
                    class=""
                    :to="`/album/${album.id}`"
                >
                    <img
                        v-if="album.cover[0]"
                        :src="album.cover[0].contentUrl"
                        alt=""
                        class="img-cover d-block mb-2"
                    >
                    <img
                        v-else
                        src="http://via.placeholder.com/400x400/fefefe"
                        alt=""
                        class="img-cover d-block mb-2"
                    >
                </router-link>

                <div class="overlay">
                    <play-button-overlay
                        @click.native="addAlbumToPlaylist"
                    />
                </div>
            </div>
            <h3 class="has-text-weight-bold">
                <router-link
                    :to="`/album/${album.id}`"
                >
                    {{ album.title }}
                </router-link>
            </h3>
            <div>
                <p class="p-0 is-inline is-album-info">
                    <strong>{{ album.artist.name }}</strong> -
                    <strong>{{ album.date }}</strong>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import { fetchOneAlbum } from 'services/albums-service';
import PlayButtonOverlay from '@/components/PlayButtonOverlay';
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'AlbumCard',
    components: {
        PlayButtonOverlay,
    },
    mixins: [playerMixin],
    props: {
        album: {
            type: Object,
            required: true,
        },
    },
    computed: {
        albumUrl() {
            return `/album/${this.album.id}`;
        },
    },
    mounted() {
    },
    methods: {
        goToAlbum() {
            window.location = this.albumUrl;
        },

        async addAlbumToPlaylist() {
            const album = (await fetchOneAlbum(this.album['@id'])).data;

            if (this.currentTrack) {
<<<<<<< HEAD
                this.currentTrack.howl.stop();
=======
                if (this.currentTrack.howl) {
                    this.currentTrack.howl.stop();
                }
>>>>>>> develop
            }
            this.$store.dispatch('playlist/initPlaylist');

            album.tracks.forEach((track) => {
                this.$store.dispatch('playlist/addTrackToPlaylist', track);
            });

            this.play();
        },
    },
};
</script>

<style lang="scss" module>
.image {
    img {
        width: 100%;
        height: auto;
    }

    h3 {
        font-size: 1.2rem;
    }
}
</style>
