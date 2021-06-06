<template>
    <div
        class="modal-card"
        style="width: auto"
    >
        <header class="modal-card-head">
            <p class="modal-card-title">
                Playlist
            </p>
        </header>
        <section class="modal-card-body">
            <div
                v-if="playlist.length"
                class="column is-one-half"
            >
                <track-list
                    :tracks="playlist"
                />
            </div>
        </section>
        <footer class="modal-card-foot">
            <b-button
                label="Close"
                @click="$parent.close()"
            />
            <b-button
                label="Login"
                type="is-primary"
            />
        </footer>
    </div>
</template>

<script>
import TrackList from '@/components/track-list';

export default {
    name: 'PlaylistModal',
    components: {
        TrackList,
    },
    props: {
        playlist: {
            type: Array,
            required: true,
        },
    },
};
</script>
