import * as React from 'react';
import { 
    List,
    Datagrid,
    TextField,
    ReferenceField,
} from 'react-admin';

import ThumbnailField from '../components/ThumbnailField';

const TracksList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <TextField source="id"/>
            <ReferenceField label="Covers" source="thumbnail" reference="media_objects">
                <ThumbnailField source="thumbnailContentUrl" />
            </ReferenceField>
            <TextField source="title" />
            <TextField source="album" />
        </Datagrid>
    </List>
);

export default TracksList;
