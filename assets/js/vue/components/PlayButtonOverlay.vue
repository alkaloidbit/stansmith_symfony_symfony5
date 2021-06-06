<template>
    <div class="play-button-overlay-renderer">
        <div class="play-button-overlay-wrapper">
            <svg-icon
                type="mdi"
                :path="path"
                :size="size"
            />
        </div>
    </div>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiPlay } from '@mdi/js';

export default {
    name: 'PlayButtonOverlay',
    components: {
        SvgIcon,
    },
    data() {
        return {
            path: mdiPlay,
            size: 48,
        };
    },
};
</script>

<style>
.play-button-overlay-renderer {
    position: absolute;
    bottom: 40px;
    right: 40px;
}
.play-button-overlay-wrapper{
    display:flex;
    align-items: center;
    justify-content:center;
    width: 80px;
    color: #FFFFFF;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    background: rgba(0, 0, 0, 0.6);
    transition: transform 200ms cubic-bezier(0.4, 0, 0.2, 1),
                    background 200ms cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}
.play-button-overlay-renderer:hover .play-button-overlay-wrapper {
    transform: scale(1.2);
    background: rgba(0, 0, 0, 1);
}
</style>
