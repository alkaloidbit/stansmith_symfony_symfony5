<template>
    <div class="albumlistindexRootContainer container">
        <div class="columns">
            <div class="column is-1">
                <loading v-show="loading" />
                <h5
                    v-show="!loading && albums.length === 0"
                    class="ml-4"
                >
                    Whoopsie Daisy, no items found!
                </h5>
            </div>
        </div>
        <div
            v-for="chunk in albumsChunks"
            :key="chunk.id"
            class="columns"
        >
            <album-card
                v-for="album in chunk"
                v-show="!loading"
                :key="album['@id']"
                :album="album"
            />
        </div>
    </div>
</template>

<script>
import AlbumCard from '@/components/album-list/album-card';
import Loading from '@/components/loading';

export default {
    name: 'AlbumList',
    data() {
        return {
        itemsPerRow: 6,
        }
    },
    components: {
        AlbumCard,
        Loading,
    },
    props: {
        loading: {
            type: Boolean,
            required: true,
        },
        albums: {
            type: Array,
            required: true,
        },
    },
    computed: {
        albumsChunks() {
            /* eslint-disable-next-line no-undef */
            return _.chunk(Object.values(this.albums), this.itemsPerRow);
        },
    },
};
</script>
