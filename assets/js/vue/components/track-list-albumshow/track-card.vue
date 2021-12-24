<template>
    <div
        class="trackCardAlbumshowRootContainer playlist-item-renderer"
        :class="[{'current-track': isCurrentTrack( track ),
                  'is-playing': isCurrentTrack( track ) && isPlaying}]"
    >
        <track-card-loading
            :track="track"
            :is-current-track="isCurrentTrack(track)"
        />
        <div class="middle-item title-wrapper">
            <span class="track-title">{{ track.title }}</span>
            <span>{{ track.artist.name }}</span>
        </div>
        <div class="right-item is-align-items-center">
            <b-dropdown
                class="dropdown-tracklist"
                append-to-body
                aria-role="menu"
                scrollable
                max-height="200"
                trap-focus
            >
                <template #trigger="{ active }">
                    <a
                        class="navbar-item"
                        role="button"
                    >
                        <b-icon icon="dots-vertical" />
                    </a>
                </template>

                <b-dropdown-item aria-role="listitem">
                    <b-icon icon="playlist-play" />
                    Lire ensuite
                </b-dropdown-item>
                <b-dropdown-item
                    aria-role="listitem"
                    @click="addTrackToPlaylist(track)"
                >
                    <b-icon icon="playlist-plus" />
                    Ajouter à la file d'attente
                </b-dropdown-item>
            </b-dropdown>
            <div class="duration">
                {{ track.playtime_string }}
            </div>
        </div>
    </div>
</template>

<script>
import playerMixin from '@/mixins/playerMixin';
import TrackCardLoading from '@/components/TrackCardLoading';

export default {
    name: 'TrackCard',
    components: {
        TrackCardLoading,
    },
    mixins: [playerMixin],
    props: {
        track: {
            type: Object,
            required: true,
        },
    },
    created() {
        // console.log('created');
    },
    methods: {
        isCurrentTrack(track) {
            if (this.currentTrack) {
                return track['@id'] === this.currentTrack['@id'];
            }
            return false;
        },
        addTrackToPlaylist(track) {
            this.$emit('playlist-plus', track);
        },
    },
};
</script>
