import * as React from 'react';
import { List, Datagrid, TextField, ImageField, DateField } from 'react-admin';

export const AlbumList = props => (
    <List {...props}>
        <Datagrid rowClick="edit" >
            <TextField source="title" />
            <TextField label="Artist" source={"artist.name"} />
            <DateField source={"date"} options={{ year: 'numeric' }} />
            <ImageField label="Cover" source={"cover[0].contentUrl"} />
            <TextField source={"cover"} />
            <TextField source={"active"} />
            <TextField source={"thumbnails"} />
            <DateField source={"created_date"} locales="fr-FR" options={{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }} />
        </Datagrid>
    </List>
)
