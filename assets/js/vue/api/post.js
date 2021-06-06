import axios from 'axios';

export default {
    create(message) {
        return axios.post('/api/posts', {
            message,
        });
    },
    findAll() {
        return axios.get('/api/posts');
    },
};
