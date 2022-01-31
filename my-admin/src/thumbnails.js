import * as React from 'react';
import { useListContext, List, TextField, DateField, ReferenceField, EditButton } from 'react-admin';
import ThumbnailField from './ThumbnailField';

const ThumbnailGrid = () => {
    const { ids, data, basePath, total } = useListContext();
    return (
        <div style={{ margin: '1em' }}>
        {ids.map(id =>
            <ThumbnailField key={id} source="contentUrl" record={data[id]} />
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
