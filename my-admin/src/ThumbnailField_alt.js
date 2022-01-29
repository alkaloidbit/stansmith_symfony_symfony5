import * as React from 'react';
import { useRecordContext } from 'react-admin';

const ThumbnailFieldAlt = ({ source }) => {
    const record = useRecordContext();
    const res = record[source];
    return record ? (
        <img src={`http://localhost:8000${res}`} alt="" />
    ) : null;
}

export default ThumbnailFieldAlt;
