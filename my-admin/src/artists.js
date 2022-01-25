import * as React from 'react';
import { 
    List,
    Datagrid,
    TextField,
    ChipField,
    ReferenceArrayField,
    SingleFieldList,
    EditButton,
} from 'react-admin';

export const ArtistsList = props => (
    <List {...props}>
        <Datagrid rowClick="edit">
            <TextField source="name" />
            <ReferenceArrayField label="Albums" reference="albums" source="albums">
                <SingleFieldList>
                    <ChipField source="id"/>
                </SingleFieldList>
            </ReferenceArrayField>
            <EditButton />
        </Datagrid>
    </List>
);
