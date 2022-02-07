import * as React from 'react';
import { 
    List,
    Datagrid,
    TextField,
    ReferenceField,
    DateField,
    BooleanField,
    EditButton,
    ShowButton,
    Edit,
    Show,
    SimpleForm,
    BooleanInput,
    TabbedShowLayout,
    Tab,
    ReferenceInput,
    ReferenceArrayField,
    ReferenceArrayInput,
    SelectArrayInput,
    AutocompleteInput,
    SelectInput,
    TextInput,
} from 'react-admin';

import CustomTextField from './CustomTextField';
import ThumbnailField from './ThumbnailField';
import AddMediaObjectButton from './AddMediaObjectButton';

export const AlbumsList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <TextField source="id"/>
            <ReferenceField label="Cover" source="cover" reference="media_objects">
                <ThumbnailField source="thumbnailContentUrl" />
            </ReferenceField>
            <TextField source="title" />
            <ReferenceField label="Artist" source="artist" reference="artists">
                <CustomTextField source="name" />
            </ReferenceField>
            <DateField source={"date"} label="Year" options={{ year: 'numeric' }} />
            <BooleanField source={"active"} />
            <DateField source={"created_date"} locales="fr-FR" />
            <EditButton />
            <ShowButton />
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
            <TextInput source="date" />
            <ReferenceArrayInput source="cover" reference="media_objects">
                <SelectArrayInput optionText="@id" />
            </ReferenceArrayInput>
            <BooleanInput source="active" />
        </SimpleForm>
    </Edit>
);

export const AlbumShow = props => (
    <Show {...props}>
        <TabbedShowLayout>
            <Tab label="Summary">
                <TextField source="id" />
                <TextField source="title" />
                <DateField source="date" />
                <BooleanField source="active" />
            </Tab>
            <Tab label="Cover" path="media_objects">
                <ReferenceArrayField
                  addLabel={false}
                  reference="media_objects"
                    source="cover"
                  target="post_id"
                >
                  <Datagrid>
                    <TextField source="id" />
                    <ThumbnailField source="coverContentUrl" />
                    <DateField source="created_date" />
                    <ShowButton />
                  </Datagrid>
                </ReferenceArrayField>
                <AddMediaObjectButton />
              </Tab>
        </TabbedShowLayout>
    </Show>
);
