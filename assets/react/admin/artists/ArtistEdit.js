import * as React from 'react';
import { 
    Edit,
    SimpleForm,
    TextInput,
} from 'react-admin';

const ArtistsEdit = props => (
    <Edit {...props}>
        <SimpleForm>
            <TextInput source="name" />

        </SimpleForm>
    </Edit>
)

export default ArtistsEdit;
