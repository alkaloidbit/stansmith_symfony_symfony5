import * as React from 'react';
import { useRecordContext } from 'react-admin';

const ThumbnailField = ({ source }) => {
    const record = useRecordContext();
    const res = record['thumbnails'][0]['contentUrl'];
    return record ? (
        <img src={`http://localhost:8000${res}`} alt="" />
    ) : null;
}

export default ThumbnailField;
