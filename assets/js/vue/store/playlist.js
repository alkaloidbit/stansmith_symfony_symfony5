import * as constants from "./mutation-types";

export default {
    namespaced: true,
    state: {
        playlist: [],
    },
    getters: {
        currentTrack(state, getters, rootState) {
            return state.playlist[rootState.currentIndex.currentIndex];
        },

        playlist(state) {
            return state.playlist;
        },
    },
    mutations: {
        // Adding a track
        [constants.ADDING_TRACK](state, track) {
            // array destructuring, the rest '...'
            state.playlist = [
                ...state.playlist,
                JSON.parse(JSON.stringify(track)),
            ];
        },

        [constants.CLEAR_PLAYLIST](state) {
            state.playlist.length = 0;
        },

        [constants.ADDING_TRACK_NEXT_IN_PLAYLIST](state, payload) {
            state.playlist.splice(
                payload.index,
                0,
                JSON.parse(JSON.stringify(payload.track))
            );
        },
    },
    actions: {
        // Adding a track object to playlist
        addTrackToPlaylist({ commit }, track) {
            commit(constants.ADDING_TRACK, track);
        },

        addTrackNextInPlaylist({ state, commit, rootState }, track) {
            commit(constants.ADDING_TRACK_NEXT_IN_PLAYLIST, {
                index: rootState.currentIndex.currentIndex + 1,
                track,
            });
        },

        initPlaylist({ commit }) {
            commit("currentIndex/SET_CURRENT_INDEX", 0, { root: true });
            commit(constants.CLEAR_PLAYLIST);
        },
    },
};
