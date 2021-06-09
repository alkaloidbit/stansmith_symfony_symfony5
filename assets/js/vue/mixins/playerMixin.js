import { mapState } from 'vuex';

export default {
    computed: {
        currentTrack() {
            return this.$store.getters['playlist/currentTrack'];
        },
        ...mapState('player', [
            'duration',
            'loopCurrentTrack',
            'isPlaying',
        ]),
        ...mapState('playlist', [
            'playlist',
        ]),
        ...mapState('currentIndex', [
            'currentIndex',
        ]),
    },

    methods: {
        play(index) {
            if (!this.currentTrack) return;

            index = typeof index === 'number' ? index : this.currentIndex;

            const track = this.playlist[index];
            const splits = track['@id'].split('/');
            const src = `/api/player/${splits[3]}/stream`;
            if (!track.howl) {
                /* eslint-disable-next-line no-undef */
                track.howl = new Howl({
                    src: [src],
                    format: ['ogg'],
                    html5: false,
                    loop: this.loopCurrentTrack,
                    onload: () => {
                    },
                    onplay: () => {
                        this.$store.dispatch('player/setDuration', { duration: track.howl.duration() }, { root: true });
                    },
                    onend: () => {
                        if (!this.loopCurrentTrack) {
                            this.skip('forward');
                        } else {
                            track.howl.play();
                        }
                    },
                });
            } else {
                console.log('howl exists!');
            }
            track.howl.play();
            this.$store.dispatch('currentIndex/setCurrentIndex', index);
            this.$store.dispatch('player/play', null, { root: true });
        },

        pause() {
            this.currentTrack.howl.pause();
            this.$store.dispatch('player/pause', null, { root: true });
        },

        skipTo(index) {
            if (this.currentTrack.howl) {
                this.currentTrack.howl.stop();
            }

            this.play(index);
        },

        skip(direction) {
            let index = 0;
            if (direction === 'forward') {
                index = this.currentIndex + 1;
                if (index >= this.playlist.length) {
                    // this.store.dispatch('player/initCurrentIndex');
                    index = 0;
                }
            } else {
                index = this.currentIndex - 1;
                if (index < 0) {
                    index = this.playlist.length - 1;
                }
            }

            this.skipTo(index);
        },
    },
};
