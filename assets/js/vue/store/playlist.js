import * as constants from './mutation-types';

export default {
    namespaced: true,
    state: {
        playlist: [],
        currentIndex: 0,
    },
    getters: {
        currentTrack(state) {
            return state.playlist[state.currentIndex];
        },
    },
    mutations: {
        [constants.ADD_TRACK](state, track) {
            state.playlist.push(track);
        },
        [constants.CLEAR_PLAYLIST](state) {
            state.playlist.length = 0;
        },
        [constants.SET_CURRENT_INDEX](state, n) {
            state.currentIndex = n;
        },
        [constants.INIT_CURRENT_INDEX](state) {
            state.currentIndex = 0;
        },
    },
    actions: {
        // Adding a track object to playlist
        addTrackToPlaylist({ commit }, track) {
            commit(constants.ADD_TRACK, track);
        },

        initPlaylist({ commit }) {
            commit(constants.SET_CURRENT_INDEX, 0);
            commit(constants.CLEAR_PLAYLIST);
        },

        setCurrentIndex({ commit }, index) {
            commit(constants.SET_CURRENT_INDEX, index);
        },
    },
};
