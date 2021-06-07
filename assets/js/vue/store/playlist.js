import * as constants from './mutation-types';

export default {
    namespaced: true,
    state: {
        playlist: [],
<<<<<<< HEAD
        currentIndex: 0,
    },
    getters: {
        currentTrack(state) {
            return state.playlist[state.currentIndex];
=======
    },
    getters: {
        currentTrack(state, getters, rootState) {
            return state.playlist[rootState.currentIndex.currentIndex];
>>>>>>> develop
        },
    },
    mutations: {
        [constants.ADD_TRACK](state, track) {
            state.playlist.push(track);
        },
        [constants.CLEAR_PLAYLIST](state) {
            state.playlist.length = 0;
        },
<<<<<<< HEAD
        [constants.SET_CURRENT_INDEX](state, n) {
            state.currentIndex = n;
        },
        [constants.INIT_CURRENT_INDEX](state) {
            state.currentIndex = 0;
        },
=======
>>>>>>> develop
    },
    actions: {
        // Adding a track object to playlist
        addTrackToPlaylist({ commit }, track) {
            commit(constants.ADD_TRACK, track);
        },

        initPlaylist({ commit }) {
<<<<<<< HEAD
            commit(constants.INIT_CURRENT_INDEX);
            commit(constants.CLEAR_PLAYLIST);
        },

        initCurrentIndex({ commit }) {
            commit(constants.INIT_CURRENT_INDEX);
        },

        setCurrentIndex({ commit }, index) {
            commit(constants.SET_CURRENT_INDEX, index);
        },
=======
            commit('currentIndex/SET_CURRENT_INDEX', 0, { root: true });
            commit(constants.CLEAR_PLAYLIST);
        },

>>>>>>> develop
    },
};
