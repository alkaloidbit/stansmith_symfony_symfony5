// import axios from 'axios';

/**
 * @param {object|null} params
 * @returns {Promise}
 */
// export function fetchArtists(params = {}) {
//     return axios.get('/api/artists', {
//         params,
//     });
// }

/**
 * @returns Array
 */
export function fetchArtists(params = {}) {
    return new Promise((resolve, reject) => {
        resolve({
            data: {
                'hydra:member': window.artists,
            },
        });
    });
}
