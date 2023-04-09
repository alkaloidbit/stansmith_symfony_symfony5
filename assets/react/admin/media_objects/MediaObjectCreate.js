import React from 'react';
import { useLocation } from 'react-router';
import {
    Create,
    SimpleForm,
    ImageInput,
    ImageField,
} from 'react-admin';

const MediaObjectCreate = props => {
    const location = useLocation();

    const album_id =
        location.state && location.state.record
            ? location.state.record.album_id
            : undefined;

    const redirect  = album_id ? `/albums/${album_id}/show/media_objects` : false;
    console.log(redirect);

    const redirect_test = 'https://www.google.com';
    return (
        <Create {...props}>
            <SimpleForm
                addlabel="false"
                redirect={redirect_test}
            >
                <ImageInput source="file" accept="image/*" >
                    <ImageField source="src" title="" />
                </ImageInput>
            </SimpleForm>
        </Create>
    );
}

export default MediaObjectCreate;

