import axios from 'axios';

export default {
    login(login, password) {
        return axios.post('/api/security/login', {
            email: login,
            password,
        }, {
            headers: {
                // 'content-type': 'application/x-www-form-urlencoded',
            },
        });
    },
    getUserData(userUri) {
        return axios.get(userUri);
    },
};
