<template>
    <div class="play-button-player-wrapper is-flex is-align-items-center">
        <svg-icon
            type="mdi"
            :path="mdiSkipPrevious"
            :size="32"
            @click.native="$emit('skip', 'backward')"
        />
        <div class="svg-wrapper">
            <svg-icon
                v-if="isPlaying"
                class="play-button"
                type="mdi"
                :path="mdiPause"
                :size="size"
                @click.native="$emit('pause')"
            />
            <svg-icon
                v-else
                class="play-button"
                type="mdi"
                :path="mdiPlay"
                :size="size"
                @click.native="$emit('play')"
            />
        </div>
        <svg-icon
            type="mdi"
            :path="mdiSkipNext"
            :size="32"
            @click.native="$emit('skip', 'forward')"
        />
    </div>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import {
    mdiPlay, mdiPause, mdiSkipPrevious, mdiSkipNext,
} from '@mdi/js';

export default {
    name: 'PlayButtonPlayer',
    components: {
        SvgIcon,
    },
    props: {
        isPlaying: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            mdiPlay,
            mdiPause,
            mdiSkipPrevious,
            mdiSkipNext,
            size: 48,
        };
    },
};
</script>

<style>
.play-button-player-wrapper .svg-wrapper{
    margin: 0px 20px;
}
</style>
