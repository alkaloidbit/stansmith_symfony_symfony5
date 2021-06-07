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
<<<<<<< HEAD
=======
        ]),
        ...mapState('currentIndex', [
>>>>>>> develop
            'currentIndex',
        ]),
    },

    methods: {
        play(index) {
            if (!this.currentTrack) return;

            index = typeof index === 'number' ? index : this.currentIndex;

<<<<<<< HEAD
            console.log('index', index);

=======
>>>>>>> develop
            const track = this.playlist[index];
            const splits = track['@id'].split('/');
            const src = `/api/player/${splits[3]}/stream`;
            if (!track.howl) {
                /* eslint-disable-next-line no-undef */
                track.howl = new Howl({
                    src: [src],
                    format: ['ogg'],
                    html5: false,
<<<<<<< HEAD
                    loop: this.loopCurrentTrack,
=======
>>>>>>> develop
                    onload: () => {
                    },
                    onplay: () => {
                        this.$store.dispatch('player/setDuration', { duration: track.howl.duration() }, { root: true });
                    },
                    onend: () => {
<<<<<<< HEAD
                        this.skip('forward');
=======
                        if (!this.loopCurrentTrack) {
                            this.skip('forward');
                        } else {
                            track.howl.play();
                        }
>>>>>>> develop
                    },
                });
            } else {
                console.log('howl exists!');
            }

            track.howl.play();
<<<<<<< HEAD
            this.$store.dispatch('playlist/setCurrentIndex', index);
=======
            this.$store.dispatch('currentIndex/setCurrentIndex', index);
>>>>>>> develop
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
<<<<<<< HEAD
                    // this.store.dispatch('player/initCurrentIndex');
=======
>>>>>>> develop
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
