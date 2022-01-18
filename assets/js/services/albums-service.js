import axios from 'axios';

/**
 * @param {string|null} artistIri
 * @parma {string|mull} searchTerm
 * @returns {Promise}
 */
export function fetchAlbums(artistIri, searchTerm) {
    const params = {};

    // /api/artists/25
    if (artistIri) {
        params.artist = artistIri;
    }

    if (searchTerm) {
        params.title = searchTerm;
    }

    // if no filter param, use window.albums as data source
    if (Object.keys(params).length === 0) {
        return new Promise((resolve, reject) => {
            resolve({
                data: {
                    'hydra:member': window.albums,
                },
            });
        });
    }

    // Filter only active albums
    params.active = true;

    // Only get those fields in the response
    const propertiesFilter = 'properties[]=id&properties[]=title&properties[]=artist&properties[]=cover&properties[]=thumbnails&properties[]=date';
    return axios.get(`/api/albums?${propertiesFilter}`, {
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
