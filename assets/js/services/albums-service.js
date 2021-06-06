import axios from 'axios';

/**
 * @param {string|null} artistIri
 * @parma {string|mull} searchTerm
 * @returns {Promise}
 */
// export function fetchAlbums(artistIri, searchTerm) {
//     const params = {};
//     if (artistIri) {
//         params.artist = artistIri;
//     }

//     if (searchTerm) {
//         params.title = searchTerm;
//     }

//     const propertiesFilter = 'properties[]=id&properties[]=title&properties[]=artist&properties[]=cover&properties[]=date';
//     const activeFilter = '&active=true';
//     return axios.get(`/api/albums?${propertiesFilter}${activeFilter}`, {
//         params,
//     });
// }
//

export function fetchAlbums(artistIri, searchTerm) {
    const params = {};
    if (artistIri) {
        params.artist = artistIri;
    }

    if (searchTerm) {
        params.title = searchTerm;
    }

    if (Object.keys(params).length === 0) {
        return new Promise((resolve, reject) => {
            resolve({
                data: {
                    'hydra:member': window.albums,
                },
            });
        });
    }

    const propertiesFilter = 'properties[]=id&properties[]=title&properties[]=artist&properties[]=cover&properties[]=date';
    const activeFilter = '&active=true';
    return axios.get(`/api/albums?${propertiesFilter}${activeFilter}`, {
        params,
    });
}

/**
 * Gets an album from the API according to the IRI.
 * @param {string} iri
 * @return {Promise}
 */
export function fetchOneAlbum(iri) {
    return axios.get(iri);
}
