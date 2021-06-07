import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist';

import SecurityModule from './security';
import PlayerModule from './player';
import PlaylistModule from './playlist';
<<<<<<< HEAD

Vue.use(Vuex);

// const vuexLocal = new VuexPersistence({
//     storage: window.localStorage,
//     supportCircular: true,
//     reducer: (state) => ({ playlist: state.playlist }),
//     filter: (mutation) => mutation.type === 'playlist/ADD_TRACK' || mutation.type === 'playlist/CLEAR_PLAYLIST',
// });
=======
import CurrentIndexModule from './currentIndex';

Vue.use(Vuex);

const vuexPlaylist = new VuexPersistence({
    key: 'vuexPlaylist',
    storage: window.localStorage,
    supportCircular: true,
    reducer: (state) => ({ playlist: state.playlist }),
    filter: (mutation) => mutation.type === 'playlist/ADD_TRACK'
    || mutation.type === 'playlist/CLEAR_PLAYLIST',
});

const vuexPlayer = new VuexPersistence({
    key: 'vuexCurrentIndex',
    storage: window.localStorage,
    supportCircular: true,
    reducer: (state) => ({ currentIndex: state.currentIndex }),
    filter: (mutation) => mutation.type === 'currentIndex/SET_CURRENT_INDEX',
});
>>>>>>> develop

export default new Vuex.Store({
    modules: {
        player: PlayerModule,
        playlist: PlaylistModule,
        security: SecurityModule,
<<<<<<< HEAD
=======
        currentIndex: CurrentIndexModule,
>>>>>>> develop
    },
    state: {
        /* User */
        userName: null,
        userEmail: null,
        userAvatar: null,
    },
    mutations: {
        user(state, payload) {
            if (payload.username) {
                state.userName = payload.username;
            }
            if (payload.email) {
                state.userEmail = payload.email;
            }
            if (payload.avatar) {
                state.userAvatar = payload.avatar;
            }
        },
    },
<<<<<<< HEAD
    // plugins: [vuexLocal.plugin],
=======
    plugins: [vuexPlaylist.plugin, vuexPlayer.plugin],
>>>>>>> develop
});
