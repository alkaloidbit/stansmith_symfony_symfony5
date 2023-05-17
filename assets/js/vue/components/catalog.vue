<template>
    <section class="catalogRootContainer">
        <div class="container is-max-widescreen">
            <div class="columns">
                <div class="column is-3">
                    <title-component :text="artistName" />
                </div>
                <div class="column is-9">
                    <search-bar @search-albums="onSearchAlbums" />
                </div>
            </div>

            <album-list
                :albums="albums"
                :loading="loading"
            />
        </div>
    </section>
</template>

<script>
import { fetchAlbums } from 'services/albums-service';
import AlbumList from '@/components/album-list';
import SearchBar from '@/components/search-bar';
import TitleComponent from '@/components/title';

export default {
    name: 'Catalog',
    comments: true,
    components: {
        AlbumList,
        TitleComponent,
        SearchBar,
    },
    props: {
        currentArtistId: {
            type: String,
            default: null,
        },
        artists: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            firstName: 'Fred',
            legend: 'Shipping takes 10-12 weeks, and products probably won\'t work',
            albums: [],
            loading: false,
            searchTerm: null,
        };
    },
    computed: {
        artistName() {
            if (this.currentArtistId === null) {
                return 'All Artists';
            }
            const artist = this.artists.find((art) => (art['@id'] === this.currentArtistId));
            return artist ? artist.name : '';
        },
    },
    watch: {
        currentArtistId() {
            this.loadAlbums();
        },
    },
    created() {
        this.loadAlbums();
    },
    methods: {
        /**
         * Handles a change in the searchTerm provided by the search bar and fetches new albums
         *
         * @param {string} term
         */
        onSearchAlbums({ term }) {
            this.searchTerm = term;
            this.loadAlbums();
        },
        async loadAlbums() {
            this.loading = true;

            let response;
            try {
                response = await fetchAlbums(this.currentArtistId, this.searchTerm);

                this.loading = false;
            } catch (e) {
                this.loading = false;

                return;
            }
            // DEBUG
            // console.log(response.data['hydra:member']);
            this.albums = response.data['hydra:member'];
        },
    },
};
</script>
