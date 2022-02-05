import * as React from 'react';
import {
    List, 
    Create,
    Edit,
    Datagrid,
    TextField,
    EditButton,
    SimpleForm,
    ReferenceInput,
    ReferenceField,
    TextInput,
    ImageInput,
    ImageField,
    SelectInput,
    required
} from 'react-admin';

import ThumbnailField from './ThumbnailField';
import CustomTextField from './CustomTextField';

export const MediaObjectsList = props => (
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

export const MediaObjectCreate = props => {
    return (
        <Create {...props}>
            <SimpleForm addLabel={false}>
                <ImageInput source="file" accept="image/*" >
                    <ImageField source="src" title="" />
                </ImageInput>
            </SimpleForm>
        </Create>
    );
}

export const MediaObjectEdit = props => {
    return (
        <Edit {...props}>
            <SimpleForm>
                <TextInput disabled source="id" />
                <TextInput disabled source="album" />
                <ThumbnailField label="Cover" source="coverContentUrl" />
            </SimpleForm> 
        </Edit>
    );
}
