import * as React from 'react';
import { 
    Create,
    SimpleForm,
    BooleanInput,
    ReferenceArrayInput,
    SelectArrayInput,
    TextInput,
} from 'react-admin';

const AlbumTitle = ({ record }) => {
    return <span>Album {record ? `"${record.title}"` : ''}</span>
}

const AlbumCreate = props => (
    <Create title={<AlbumTitle />} {...props}>
        <SimpleForm>
            <TextInput disabled source="id" />
            <TextInput source="title" />
            <TextInput source="date" />
            <ReferenceArrayInput source="cover" reference="media_objects">
                <SelectArrayInput optionText="@id" />
            </ReferenceArrayInput>
            <BooleanInput source="active" />
        </SimpleForm>
    </Create>
);

export default AlbumCreate;
