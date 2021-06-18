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
                                :data-src="album.cover[0].contentUrl"
                                :data-loading="album.thumbnails[0].contentUrl"
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
                        <track-list
                            :tracks="album.tracks"
                            :on-playlist="false"
                            :selected-track="{}"
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
import TrackList from '@/components/track-list';
// import TitleComponent from '@/components/title';
// import dayjs from 'dayjs';
// import duration from 'dayjs/plugin/duration';
import formatPlaytime from '../helpers/formatPlaytime';

// dayjs.extend(duration);

export default {
    name: 'AlbumShow',
    components: {
        Loading,
        // TitleComponent,
        TrackList,
    },
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
};
</script>
