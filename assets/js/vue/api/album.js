import axios from 'axios';

export default {
    create(album) {
        return axios.post('/api/albums', {
            album,
        });
    },
    findAll() {
        return axios.get('/api/albums');
    },
};
