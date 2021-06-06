<template>
    <div
        class="repeat-control-renderer
                is-align-items-center
                is-flex"
    >
        <div class="svg-wrapper">
            <svg-icon
                v-if="loopCurrentTrack"
                type="mdi"
                :path="mdiRepeatOnce"
                :size="size"
                @click.native="toggleRepeat()"
            />
            <svg-icon
                v-else
                type="mdi"
                :path="mdiRepeat"
                :size="size"
                @click.native="toggleRepeat()"
            />
        </div>
    </div>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import {
    mdiRepeat, mdiRepeatOnce, mdiRepeatOff,
} from '@mdi/js';

export default {
    name: 'RepeatControl',
    components: {
        SvgIcon,
    },
    data() {
        return {
            mdiRepeat,
            mdiRepeatOff,
            mdiRepeatOnce,
            size: 32,
        };
    },
    computed: {
        loopCurrentTrack() {
            return this.$store.state.player.loopCurrentTrack;
        },
    },
    created() {
    },
    methods: {
        toggleRepeat() {
            this.$store.dispatch('player/toggleLoopCurrentTrack');
        },
    },
};
</script>

<style lang="scss">

.repeat-control-renderer {
    width: 40%;
}

</style>
