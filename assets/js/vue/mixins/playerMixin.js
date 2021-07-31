import { mapState } from 'vuex';

export default {
    computed: {
        currentTrack() {
            const currentTrack = this.$store.getters['playlist/currentTrack'];
            return currentTrack;
        },
        ...mapState('player', [
            'duration',
            'loopCurrentTrack',
            'isPlaying',
            'isLoading',
            'isLoaded',
        ]),
        ...mapState('playlist', [
            'playlist',
        ]),
        ...mapState('currentIndex', [
            'currentIndex',
        ]),
    },

    created() {
    },
    methods: {
        play(index) {
            if (!this.currentTrack) return;
            index = typeof index === 'number' ? index : this.currentIndex;

            // const [track1] = this.playlist;
            // console.log(track1);

            const track = this.playlist[index];
            const splits = track['@id'].split('/');
            const src = `/api/player/${splits[3]}/stream`;

            if (!track.howl) {
                this.$store.dispatch('player/onLoading');
                console.log('creating new Howl');
                /* eslint-disable-next-line no-undef */
                track.howl = new Howl({
                    src: [src],
                    format: [track.fileformat],
                    html5: false,
                    loop: this.loopCurrentTrack,
                    pool: 5,
                    onload: () => {
                        this.$store.dispatch('player/onLoadingSuccess', { duration: track.howl.duration() }, { root: true });
                    },
                    onplay: () => {
                        this.$store.dispatch('player/play', { isPlaying: true });
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
                console.log('Howl exists!');
            }

            this.$store.dispatch('currentIndex/setCurrentIndex', index);

            track.howl.play();
            this.setTitle(track);
        },

        setTitle(track) {
            document.title = `${track.title} - StansMusic`;
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
