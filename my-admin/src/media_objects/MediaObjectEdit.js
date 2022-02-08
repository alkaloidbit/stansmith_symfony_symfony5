import React from 'react';
import {
    Edit,
    SimpleForm,
    TextInput,
} from 'react-admin';

import ThumbnailField from '../components/ThumbnailField';

const MediaObjectEdit = props => {
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

export default MediaObjectEdit;
