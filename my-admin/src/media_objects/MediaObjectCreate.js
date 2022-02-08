import React from 'react';
import {
    Create,
    SimpleForm,
    ImageInput,
    ImageField,
} from 'react-admin';

const MediaObjectCreate = props => {
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

export default MediaObjectCreate;