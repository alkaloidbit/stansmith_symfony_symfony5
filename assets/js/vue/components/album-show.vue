<template>
    <div class="albumShowRootContainer column">
        <div class="columns">
            <div class="column">
                <loading v-if="loading" />
                <div class="hero ">
                    <div
                        v-if="album"
                        class="hero-body"
                    >
                        <p class="title">
                            {{ album.title }}
                        </p>
                        <p class="subtitle">
                            {{ album.artist.name }} - {{ album.date }}
                        </p>
                        <p class="subtitle">
                            {{ totalTracks }} titres - {{ totalPlaytime }}
                        </p>
                        <b-button
                            type="is-dark"
                            icon-left="play"
                            outlined
                            @click="addAlbumToPlaylist()"
                        >
                            LIRE
                        </b-button>
                    </div>
                </div>
            </div>
        </div>
        <section>
            <div class="container is-fluid">
                <div class="columns">
                    <div
                        v-if="album"
                        class="column is-one-half"
                    >
                        <div
                            v-lazy-container="{ selector: 'img' }
                            "
                            class="is-album-cover"
                        >
                            <img
                                v-if="album.cover[0]"
                                :data-src="album.cover[0].coverContentUrl"
                                :data-loading="album.thumbnails[0].coverContentUrl"
                                alt=""
                                class="img-cover"
                            >
                            <img
                                v-else
                                src="http://via.placeholder.com/400x400/fefefe"
                                class="img-cover"
                                alt=""
                            >
                            <div class="overlay" />
                        </div>
                    </div>
                    <div
                        v-if="album"
                        class="column is-one-half"
                    >
                        <track-list-albumshow
                            :tracks="album.tracks"
                        />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { fetchOneAlbum } from 'services/albums-service';
import Loading from '@/components/loading';
import TrackListAlbumshow from '@/components/track-list-albumshow';
import playerMixin from '@/mixins/playerMixin';
import formatPlaytime from '../helpers/formatPlaytime';

export default {
    name: 'AlbumShow',
    components: {
        Loading,
        TrackListAlbumshow,
    },
    mixins: [playerMixin],
    props: {
        albumId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            album: null,
            loading: true,
        };
    },
    computed: {
        totalPlaytime() {
            return formatPlaytime(this.album.total_playtime_seconds);
        },
        totalTracks() {
            return this.album.tracks.length;
        },
    },
    async created() {
        try {
            this.album = (await fetchOneAlbum(this.albumId)).data;
        } finally {
            this.loading = false;
        }
    },
    methods: {
        addAlbumToPlaylist() {
            if (this.currentTrack) {
                if (this.currentTrack.howl) {
                    this.currentTrack.howl.stop();
                }
            }
            this.$store.dispatch('playlist/initPlaylist');

            this.album.tracks.forEach((track) => {
                this.$store.dispatch('playlist/addTrackToPlaylist', track);
            });

            this.play();
        },
    },
};
</script>
