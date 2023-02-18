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
} from 'react-admin';

import CustomTextField from '../components/CustomTextField';
import ThumbnailField from '../components/ThumbnailField';

const AlbumsList = props => (
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


export default AlbumsList;