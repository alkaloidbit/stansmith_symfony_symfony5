
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


const ArtistsList = props => (
    <List {...props}>
        <Datagrid rowClick="edit">
            <TextField source="id"/>
            <TextField source="name" />
            <ReferenceArrayField label="Albums" reference="albums" source="albums">
                <SingleFieldList>
                    <ChipField source="title"/>
                </SingleFieldList>
            </ReferenceArrayField>
            <EditButton />
        </Datagrid>
    </List>
);

export default ArtistsList;
