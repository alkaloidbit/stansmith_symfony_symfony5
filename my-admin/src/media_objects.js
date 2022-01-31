import * as React from 'react';
import {
    List, 
    Datagrid,
    TextField,
    EditButton,
} from 'react-admin';

import ThumbnailField from './ThumbnailField';

export const MediaObjectsList = props => (
    <List {...props}>
        <Datagrid >
            <ThumbnailField source="contentUrl" />
            <TextField source="fileName" />
        </Datagrid>
    </List>
);
