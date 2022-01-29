import * as React from 'react';
import { useRecordContext } from 'react-admin';

const ThumbnailFieldAlt = (props) => {
    const { source } = props;
    const record = useRecordContext(props);
    return record ? (
        <img src={`http://localhost:8000${record[source]}`} alt="" />
    ) : null;
}

export default ThumbnailFieldAlt;
