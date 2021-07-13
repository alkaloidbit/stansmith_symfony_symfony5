import * as constants from './mutation-types';

export default {
    namespaced: true,
    state: {
        duration: null,
        isPlaying: false,
        loopCurrentTrack: false,
        isLoading: false,
        isLoaded: false,
    },
    getters: {
        isLoaded(state) {
            return state.isLoaded;
        },
    },
    mutations: {
        [constants.LOADING](state) {
            state.isLoading = true;
            state.isLoaded = false;
            state.isPlaying = false;
            state.duration = null;
        },
        [constants.LOADING_SUCCESS](state, payload) {
            state.isLoading = false;
            state.isLoaded = true;
            state.isPlaying = false;
            state.duration = payload.duration;
        },
        [constants.PLAYING](state, payload) {
            state.isPlaying = payload.isPlaying;
            state.isLoaded = true;
            state.isLoading = false;
        },
        [constants.TOGGLE_LOOP_CURRENT_TRACK](state) {
            state.loopCurrentTrack = !state.loopCurrentTrack;
        },
    },
    actions: {
        onLoading({ commit }) {
            commit(constants.LOADING);
        },

        onLoadingSuccess({ commit }, payload) {
            commit(constants.LOADING_SUCCESS, payload);
        },

        play({ commit }) {
            commit(constants.PLAYING, { isPlaying: true });
        },

        pause({ commit }) {
            commit(constants.PLAYING, { isPlaying: false });
        },

        toggleLoopCurrentTrack({ commit }) {
            commit(constants.TOGGLE_LOOP_CURRENT_TRACK);
        },
    },
};
