import * as constants from './mutation-types';

export default {
    namespaced: true,
    state: {
        duration: null,
        isPlaying: false,
        loopCurrentTrack: false,
    },
    getters: {
    },
    mutations: {
        [constants.SET_IS_PLAYING](state, payload) {
            state.isPlaying = payload.isPlaying;
        },
        [constants.SET_DURATION](state, payload) {
            state.duration = payload.duration;
        },
        [constants.TOGGLE_LOOP_CURRENT_TRACK](state) {
            state.loopCurrentTrack = !state.loopCurrentTrack;
        },
    },
    actions: {
        setDuration({ commit }, payload) {
            commit(constants.SET_DURATION, payload);
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
<<<<<<< HEAD
=======

>>>>>>> develop
    },
};
