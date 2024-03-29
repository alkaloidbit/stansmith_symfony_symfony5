import * as React from "react";
import {
  Datagrid,
  TextField,
  DateField,
  BooleanField,
  ListButton,
  RefreshButton,
  ShowButton,
  Show,
  TabbedShowLayout,
  Tab,
  ReferenceArrayField,
  ReferenceField,
  ImageField,
} from "react-admin";
import CardActions from "@mui/material/CardActions";

const AlbumShowActions =  ({ basePath }) => (
  <CardActions>
    <ListButton basePath={basePath} />
    <RefreshButton />
  </CardActions>
);

const AlbumShow = props => (
  <Show {...props} actions={<AlbumShowActions />}>
    <TabbedShowLayout>
      <Tab label="Summary">
        <TextField source="id" />
        <TextField source="title" />
        <ReferenceField label="Artist" source="artist" reference="artists">
          <TextField source="name" />
        </ReferenceField>
        <TextField source="date" label="Year"/>
        <BooleanField source="active" />
      </Tab>
      <Tab label="Covers" path="media_objects">
        <ReferenceArrayField
          addLabel={false}
          reference="media_objects"
          source="covers"
        >
          <Datagrid>
            <TextField source="id" />
            <ImageField label="Cover" source="coverContentUrl" />
            <DateField source="created_date" />
            <ShowButton />
          </Datagrid>
        </ReferenceArrayField>
      </Tab>
    </TabbedShowLayout>
  </Show>
);

export default AlbumShow;
