
import * as React from 'react';
import { 
    Edit,
    SimpleForm,
    BooleanInput,
    ReferenceArrayInput,
    SelectArrayInput,
    TextInput,
} from 'react-admin';

const AlbumTitle = ({ record }) => {
    return <span>Album {record ? `"${record.title}"` : ''}</span>
}

const AlbumEdit = props => (
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

export default AlbumEdit;
