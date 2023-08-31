<script>
import AudioPlayer from "./components/audio-player.vue";
import { Howl } from "howler";

export default {
    components: {
        AudioPlayer,
    },

    data() {
        return {
            audioSources: [
                // "/api/player/06c1fe6bb730efaec032231d848ced5d/stream",
                "assets/audio/audio1.mp3"
            ],
        };
    },
    created() {
    },
};
</script>

<template>
    <div>
        <audio-player
            :autoplay="true"
            :html5="true"
            :sources="audioSources"
            :loop="true"
        ></audio-player>
    </div>
</template>
