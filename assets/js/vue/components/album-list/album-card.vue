<template>
    <div class="albumListalbumCardRootContainer column is-2">
        <div
            :class="$style.image"
            class="is-album-cover"
        >
            <router-link
                class=""
                :to="`/album/${album.id}`"
            >
                <div v-lazy-container="{ selector: 'img' }">
                    <img
                        v-if="album.covers[0]"
                        :data-src="album.covers[0].coverContentUrl"
                        :data-loading="album.covers[0].placeholderContentUrl"
                        alt=""
                        class="img-cover d-block mb-2"
                    >
                    <img
                        v-else
                        src="http://via.placeholder.com/400x400/fefefe"
                        alt=""
                        class="img-cover d-block mb-2"
                    >
                </div>
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
                <router-link
                    :to="`/artist/${album.artist.id}`">
                    <span>{{ album.artist.name }}</span> -
                </router-link>
                <span>{{ album.date }}</span>
            </p>
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
                if (this.currentTrack.howl) {
                    this.currentTrack.howl.stop();
                }
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
    img[lazy=loading] {
    /*your style here*/
        filter: blur(5px);
    }
    img[lazy=error] {
    /*your style here*/
    }
    img[lazy=loaded] {
    /*your style here*/
        filter: none;
        transition: filter 1s;
    }
}
</style>
