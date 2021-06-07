import * as constants from './mutation-types';

export default {
    namespaced: true,
    state: {
        currentIndex: 0,
    },
    getters: {
    },
    mutations: {
        [constants.SET_CURRENT_INDEX](state, n) {
            state.currentIndex = n;
        },
    },
    actions: {
        // Adding a track object to playlist
        setCurrentIndex({ commit }, index) {
            commit(constants.SET_CURRENT_INDEX, index);
        },
    },
};
