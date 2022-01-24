import * as React from 'react';
import { 
    List,
    Datagrid,
    TextField,
    ImageField,
    DateField
} from 'react-admin';
// import CoverField from './CoverField';
import ThumbnailField from './ThumbnailField';

export const AlbumsList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <ThumbnailField label="Image" source={"thumbnails"} src="contentUrl"/>
            <TextField source="title" />
            <TextField label="Artist" source={"artist.name"} />
            <DateField source={"date"} label="Year" options={{ year: 'numeric' }} />
            <TextField source={"active"} />
            <DateField source={"created_date"} locales="fr-FR" />
        </Datagrid>
    </List>
)
