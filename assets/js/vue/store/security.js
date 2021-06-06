import SecurityAPI from '../api/security';

const AUTHENTICATING = 'AUTHENTICATING';
const AUTHENTICATING_SUCCESS = 'AUTHENTICATING_SUCCESS';
const AUTHENTICATING_ERROR = 'AUTHENTICATING_ERROR';
const PROVIDING_DATA_ON_REFRESH_SUCCESS = 'PROVIDING_DATA_ON_REFRESH_SUCCESS';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        isAuthenticated: false,
        user: null,
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        hasError(state) {
            return state.error !== null;
        },
        error(state) {
            return state.error;
        },
        isAuthenticated(state) {
            return state.isAuthenticated;
        },
        hasRole(state) {
            return (role) => state.user.roles.indexOf(role) !== -1;
        },
        getUser(state) {
            return state.user;
        },
    },
    mutations: {
        [AUTHENTICATING](state) {
            state.isLoading = true;
            state.error = null;
            state.isAuthenticated = false;
            state.user = null;
        },
        [AUTHENTICATING_SUCCESS](state, user) {
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = true;
            state.user = user;
        },
        [AUTHENTICATING_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.isAuthenticated = false;
            state.user = null;
        },
        [PROVIDING_DATA_ON_REFRESH_SUCCESS](state, payload) {
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = payload.isAuthenticated;
            state.user = payload.user;
        },
    },
    actions: {
        async login({ commit }, payload) {
            // commit AUTHENTICATING mutation, kicks off a pending state by showing loading spinner
            commit(AUTHENTICATING);

            try {
                // async results of login via axios
                // return 204 no content for success
                const loginRes = await SecurityAPI.login(payload.login, payload.password);
                // getting user api resource location
                const userUri = loginRes.headers.location;

                // async getting userData
                await SecurityAPI.getUserData(userUri)
                    .then((response) => {
                        // commiting success mutation
                        // making user state and isAuthenticated
                        commit(AUTHENTICATING_SUCCESS, response.data);
                        commit('user', response.data, { root: true });
                    });

                return loginRes.data;
            } catch (error) {
                console.log('Error caught in login action:', error.response.data.error);
                commit(AUTHENTICATING_ERROR, error);
                return null;
            }
        },
        onRefresh({ commit }, payload) {
            commit(PROVIDING_DATA_ON_REFRESH_SUCCESS, payload);
        },
    },
};
