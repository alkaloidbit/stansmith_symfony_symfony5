import * as constants from './mutation-types';

export default {
    namespaced: true,
    state: {
        currentIndex: 0,
    },
    getters: {
        currentIndex(state) {
            return state.currentIndex;
        },
    },
    mutations: {
        [constants.SET_CURRENT_INDEX](state, n) {
            state.currentIndex = n;
        },
    },
    actions: {
        setCurrentIndex({ commit }, index) {
            commit(constants.SET_CURRENT_INDEX, index);
        },
    },
};
