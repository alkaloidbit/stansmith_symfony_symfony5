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
    SelectInput,
    TextInput,
} from 'react-admin';

import ThumbnailField from './ThumbnailField';

export const AlbumsList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <ThumbnailField label="Cover" source={"thumbnails"} src="contentUrl"/>
            <TextField source="title" />
            <TextField label="Artist" source={"artist.name"} />
            <DateField source={"date"} label="Year" options={{ year: 'numeric' }} />
            <BooleanField source={"active"} />
            <DateField source={"created_date"} locales="fr-FR" />
            <EditButton />
        </Datagrid>
    </List>
)

const AlbumTitle = ({ record }) => {
    return <span>Album {record ? `"${record.title}"` : ''}</span>
}
export const AlbumEdit = props => (
    <Edit title={<AlbumTitle />} {...props}>
        <SimpleForm>
            <TextInput source="title" />
            <TextInput source="date" />
            <BooleanInput source="active" />
        </SimpleForm>
    </Edit>
);
