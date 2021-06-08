<template>
    <div
        class="volume-control-renderer
                is-align-items-center
                is-flex"
    >
        <div class="is-volume-slider">
            <b-slider
                v-model="volume"
                :min="min"
                size="is-small"
                :max="max"
                :step="step"
                rounded
                :tooltip="false"
                bigger-slider-focus
                @input="updateVolume(volume)"
            />
        </div>
        <div class="svg-wrapper">
            <template v-if="!muted">
                <svg-icon
                    v-if="volume == 0"
                    type="mdi"
                    :path="mdiVolumeOff"
                    :size="size"
                    @click.native="toggleMute()"
                />
                <svg-icon
                    v-else-if="volume < 0.15"
                    type="mdi"
                    :path="mdiVolumeLow"
                    :size="size"
                    @click.native="toggleMute()"
                />
                <svg-icon
                    v-else-if="volume > 0.55"
                    type="mdi"
                    :path="mdiVolumeHigh"
                    :size="size"
                    @click.native="toggleMute()"
                />
                <svg-icon
                    v-else
                    type="mdi"
                    :path="mdiVolumeMedium"
                    :size="size"
                    @click.native="toggleMute()"
                />
            </template>
            <svg-icon
                v-show="muted"
                type="mdi"
                :path="mdiVolumeOff"
                :size="size"
                @click.native="toggleMute()"
            />
        </div>
    </div>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import {
    mdiVolumeHigh, mdiVolumeOff, mdiVolumeMedium, mdiVolumeLow,
} from '@mdi/js';

export default {
    name: 'VolumeControl',
    components: {
        SvgIcon,
    },
    data() {
        return {
            mdiVolumeHigh,
            mdiVolumeLow,
            mdiVolumeMedium,
            mdiVolumeOff,
            size: 32,
            volume: 0.5,
            volumeMuted: null,
            max: 1,
            step: 0.05,
            min: 0,
            muted: false,
        };
    },
    created() {
        /* eslint-disable-next-line no-undef */
        Howler.volume(this.volume);
    },
    methods: {
        updateVolume(volume) {
            /* eslint-disable-next-line no-undef */
            Howler.volume(volume);

            if (volume === 0) {
                this.muted = true;
                /* eslint-disable-next-line no-undef */
                Howler.mute(true);
            } else {
                /* eslint-disable-next-line no-undef */
                Howler.mute(false);
                this.muted = false;
            }
        },
        toggleMute() {
            if (!this.muted) {
                // volume when muting
                this.volumeMuted = this.volume;
            }

            // Muting action
            /* eslint-disable-next-line no-undef */
            Howler.mute(!this.muted);
            this.muted = !this.muted;

            if (this.muted) {
                this.volume = 0;
            } else {
                this.volume = this.volumeMuted;
            }
        },
    },
};
</script>

<style lang="scss">
.volume-control-renderer {
    width: 40%;
    .is-volume-slider {
        width: 100%;
        margin-right: 40px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    &:hover .is-volume-slider {
        opacity: 1;
    }
}
</style>
