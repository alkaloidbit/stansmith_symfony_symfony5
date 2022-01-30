import * as React from 'react';
import { useListContext, List, TextField, DateField, ReferenceField, EditButton } from 'react-admin';
import ThumbnailFieldAlt from './ThumbnailField_alt';

const ThumbnailGrid = () => {
    const { ids, data, basePath, total } = useListContext();
    return (
        <div style={{ margin: '1em' }}>
        {ids.map(id =>
            <ThumbnailFieldAlt key={id} source="contentUrl" record={data[id]} />
        )}
        </div>
    );
};

const ThumbnailList = (props) => (
    <List title="All comments" {...props}>
        <ThumbnailGrid />
    </List>
);

export default ThumbnailList;  
