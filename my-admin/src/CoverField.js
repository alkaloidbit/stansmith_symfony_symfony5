import * as React from 'react';
import { useRecordContext } from 'react-admin';

const CoverField = ({ source }) => {
    const record = useRecordContext();
    const res = record['cover'][0]['contentUrl'];
    return record ? (
        <img src={"http://localhost:8000"+ res} alt="" />
    ) : null;
}

export default CoverField;
