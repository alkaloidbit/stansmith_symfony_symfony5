import * as React from 'react';
import { 
    List,
    Datagrid,
    TextField,
    DateField,
    BooleanField,
    EditButton,
} from 'react-admin';

import ThumbnailField from './ThumbnailField';

export const AlbumsList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <TextField source="id" />
            <ThumbnailField label="Cover" source={"thumbnails"} src="contentUrl"/>
            <TextField source="title" />
            <TextField label="Artist" source={"artist.name"} />
            <DateField source={"date"} label="Year" options={{ year: 'numeric' }} />
            <BooleanField source={"active"} />
            <DateField source={"created_date"} locales="fr-FR" />
            <EditButton />
        </Datagrid>
    </List>
)
