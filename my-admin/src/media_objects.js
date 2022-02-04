import * as React from 'react';
import {
    List, 
    Create,
    Edit,
    Datagrid,
    TextField,
    EditButton,
    SimpleForm,
    ReferenceInput,
    TextInput,
    SelectInput,
    required
} from 'react-admin';

import ThumbnailField from './ThumbnailField';

export const MediaObjectsList = props => (
    <List {...props}>
        <Datagrid >
            <ThumbnailField label="Cover" source="thumbnailContentUrl" />
            <TextField source="fileName" label="Cover filename" />
            <EditButton />
        </Datagrid>
    </List>
);

export const MediaObjectEdit = props => {
    return (
        <Edit {...props}>
            <SimpleForm>
                <TextInput disabled source="id" />
                <ReferenceInput
                    source=""
                    reference=""
                    allowEmpty
                    validate={required()}
                >
                    <SelectInput optionText="title" />
                </ReferenceInput>
            </SimpleForm> 
        </Edit>
    )
}

export const MediaObjectCreate = props => {
    return (
        <Create {... props}>
            <SimpleForm>
                <ReferenceInput 
                    source=""
                    reference=""
                    allowEmpty
                    validate={required()}
                >
                    <SelectInput optionText="title" />
                </ReferenceInput>
            </SimpleForm>
        </Create>
    )
}
