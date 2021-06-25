import * as constants from './mutation-types';

const LOADING = 'LOADING';
const LOADING_SUCCESS = 'LOADING_SUCCESS';

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
    },
    mutations: {
        [LOADING](state) {
            state.isLoading = true;
            state.isPlaying = false;
        },
        [LOADING_SUCCESS](state) {
            state.isLoading = false;
            state.isLoaded = true;
        },
        [constants.SET_IS_PLAYING](state, payload) {
            state.isPlaying = payload.isPlaying;
        },
        [constants.SET_DURATION](state, payload) {
            state.duration = payload.duration;
        },
        [constants.TOGGLE_LOOP_CURRENT_TRACK](state) {
            state.loopCurrentTrack = !state.loopCurrentTrack;
        },
        [constants.SET_IS_LOADING](state, payload) {
            state.isLoading = payload.isLoading;
        },
    },
    actions: {
        setDuration({ commit }, payload) {
            commit(constants.SET_DURATION, payload);
        },

        setIsLoading({ commit }, payload) {
            commit(constants.SET_IS_LOADING, payload);
        },

        play({ commit }) {
            commit(constants.SET_IS_PLAYING, { isPlaying: true });
        },

        pause({ commit }) {
            commit(constants.SET_IS_PLAYING, { isPlaying: false });
        },

        toggleLoopCurrentTrack({ commit }) {
            commit(constants.TOGGLE_LOOP_CURRENT_TRACK);
        },
    },
};
