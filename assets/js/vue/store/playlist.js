import * as constants from './mutation-types';

export default {
    namespaced: true,
    state: {
        playlist: [],
    },
    getters: {
        currentTrack(state, getters, rootState) {
            return state.playlist[rootState.currentIndex.currentIndex];
        },
    },
    mutations: {
        [constants.ADDING_TRACK](state, track) {
            state.playlist.push(track);
        },
        [constants.CLEAR_PLAYLIST](state) {
            state.playlist.length = 0;
        },
    },
    actions: {
        // Adding a track object to playlist
        addTrackToPlaylist({ commit }, track) {
            commit(constants.ADDING_TRACK, track);
        },

        initPlaylist({ commit }) {
            commit('currentIndex/SET_CURRENT_INDEX', 0, { root: true });
            commit(constants.CLEAR_PLAYLIST);
        },
    },
};
