import * as musicMetadata from 'music-metadata-browser';

export default function (track) {
    const splits = track['@id'].split('/');
    const src = `/api/player/${splits[3]}/stream`;
    fetch(src).then((response) => response.blob()).then((blobdata) => {
        musicMetadata.parseBlob(blobdata).then((metadata) => {
            console.log(metadata);
        });
    });
}
