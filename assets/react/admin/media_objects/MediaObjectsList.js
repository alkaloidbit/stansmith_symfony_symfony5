import React from 'react';
import {
    List,
    Datagrid,
    TextField,
    ImageField,
    ReferenceField,
    EditButton,
} from 'react-admin';

import CustomTextField from '../components/CustomTextField';

const MediaObjectsList = props => (
    <List {...props}>
        <Datagrid >
            <TextField source="id" label="Id" />
            <ImageField label="Covers" source="coverContentUrl" />
            <TextField source="fileName" label="Filename" />
            <ReferenceField label="Album" source="album" reference="albums">
                <CustomTextField source="title" />
            </ReferenceField>
            <EditButton />
        </Datagrid>
    </List>
);

export default MediaObjectsList;
