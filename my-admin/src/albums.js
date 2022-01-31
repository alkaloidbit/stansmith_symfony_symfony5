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

import ThumbnailField from './ThumbnailField';
import CustomTextField from './CustomTextField';
import ThumbnailFieldAlt from './ThumbnailField_alt';

export const AlbumsList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <TextField source="id"/>
            <ReferenceField label="Cover" source="mainThumbnail" reference="thumbnail_objects">
                <ThumbnailFieldAlt source="contentUrl" />
            </ReferenceField>
            <TextField source="title" />
            <ReferenceField label="Artist" source="artist" reference="artists">
                <CustomTextField source="name" />
            </ReferenceField>
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
            <TextInput disabled source="id" />
            <TextInput source="title" />
            {/*<ReferenceInput 
                disabled
                label="artist"
                source="artist" 
                reference="artists"
                filterToQuery={searchText => ({ name: searchText })}
                format={v => v['@id'] || v}
            >
                <AutocompleteInput optionText="name" />
            </ReferenceInput>*/}
            <TextInput source="date" />
            {/*<ReferenceArrayInput source="cover" reference="media_objects">
                <SelectArrayInput optionText="@id" />
            </ReferenceArrayInput>*/}
            <BooleanInput source="active" />
        </SimpleForm>
    </Edit>
);
