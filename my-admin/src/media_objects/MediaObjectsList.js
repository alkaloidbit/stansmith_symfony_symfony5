import React from 'react';
import {
    List,
    Datagrid,
    TextField,
    ReferenceField,
    EditButton,
} from 'react-admin';

import ThumbnailField from '../components/ThumbnailField';
import CustomTextField from '../components/CustomTextField';

const MediaObjectsList = props => (
    <List {...props}>
        <Datagrid >
            <TextField source="id" label="Id" />
            <ThumbnailField label="Cover" source="thumbnailContentUrl" />
            <TextField source="fileName" label="Filename" />
            <ReferenceField label="Album" source="album" reference="albums">
                <CustomTextField source="title" />
            </ReferenceField>
            <EditButton />
        </Datagrid>
    </List>
);

export default MediaObjectsList;
