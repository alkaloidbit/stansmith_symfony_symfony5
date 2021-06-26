import * as constants from './mutation-types';

const LOADING = 'LOADING';
const LOADING_SUCCESS = 'LOADING_SUCCESS';
const PLAYING = 'PLAYING';

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
            state.isLoaded = false;
            state.isPlaying = false;
            state.duration = null;
        },
        [LOADING_SUCCESS](state, payload) {
            state.isLoading = false;
            state.isLoaded = true;
            state.isPlaying = false;
            state.duration = payload.duration;
        },
        [PLAYING](state, payload) {
            state.isPlaying = payload.isPlaying;
            state.isLoaded = true;
            state.isLoading = false;
        },
        [constants.SET_IS_PLAYING](state, payload) {
            state.isPlaying = payload.isPlaying;
            state.isLoading = false;
            state.isLoaded = true;
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

        setLoading({ commit }) {
            commit(LOADING);
        },

        setLoadingSuccess({ commit }, payload) {
            commit(LOADING_SUCCESS, payload);
        },

        play({ commit }) {
            commit(PLAYING, { isPlaying: true });
        },

        pause({ commit }) {
            commit(PLAYING, { isPlaying: false });
        },

        toggleLoopCurrentTrack({ commit }) {
            commit(constants.TOGGLE_LOOP_CURRENT_TRACK);
        },
    },
};
