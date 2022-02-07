
import * as React from 'react';
import { 
    List,
    Datagrid,
    TextField,
    ReferenceField,
    DateField,
    BooleanField,
    EditButton,
    Edit,
    SimpleForm,
    BooleanInput,
    ReferenceInput,
    ReferenceArrayInput,
    SelectArrayInput,
    AutocompleteInput,
    SelectInput,
    TextInput,
} from 'react-admin';

import CustomTextField from './CustomTextField';
import ThumbnailField from './ThumbnailField';

export const TracksList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <TextField source="id"/>
            <ReferenceField label="Cover" source="thumbnail" reference="media_objects">
                <ThumbnailField source="thumbnailContentUrl" />
            </ReferenceField>
            <TextField source="title" />
            <TextField source="album" />
        </Datagrid>
    </List>
);
