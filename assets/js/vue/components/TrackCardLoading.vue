<template>
    <div>
        <div
            v-if="isCurrentTrack && isPlaying"
            class="sk-swing"
        >
            <div class="sk-swing-dot" />
            <div class="sk-swing-dot" />
        </div>
        <div
            v-else-if="isCurrentTrack && isLoading"
            class="sk-bounce"
        >
            <div class="sk-bounce-dot" />
            <div class="sk-bounce-dot" />
        </div>
        <div
            v-else-if="isCurrentTrack && isLoaded && !isPlaying"
            class="left-item"
        >
            <span
                class="play icon is-large"
            >
                <i class="mdi mdi-36px mdi-play" />
            </span>
        </div>
        <div
            v-else
            class="left-item"
        >
            <span
                class="tracknumber"
            >{{ track.tracknumber }}</span>
        </div>
    </div>
</template>

<script>
import playerMixin from '@/mixins/playerMixin';

export default {
    name: 'TrackCardLoading',
    mixins: [playerMixin],
    props: {
        track: {
            type: Object,
            required: true,
        },
        isCurrentTrack: {
            type: Boolean,
            required: true,
        },
    },
    created() {
    },
    methods: {
    },
};
</script>
