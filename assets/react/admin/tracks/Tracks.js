import * as React from 'react';
import { 
    List,
    Datagrid,
    TextField,
    ImageField,
    ReferenceField,
} from 'react-admin';

const TracksList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <TextField source="id"/>
            <ReferenceField label="Covers" source="thumbnail" reference="media_objects">
                <ImageField source="coverContentUrl" />
            </ReferenceField>
            <TextField source="title" />
            <TextField source="album" />
        </Datagrid>
    </List>
);

export default TracksList;
