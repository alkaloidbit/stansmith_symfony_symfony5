import * as React from 'react';
import {
    List, 
    Datagrid,
    TextField,
    EditButton,
} from 'react-admin';

export const MediaObjectsList = props => (
    <List {...props}>
        <Datagrid >
            <TextField source="contentUrl" />
            <TextField source="fileName" />
        </Datagrid>
    </List>
);
