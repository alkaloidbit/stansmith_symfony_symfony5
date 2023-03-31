import * as React from "react";
import {
  List,
  Datagrid,
  TextField,
  ReferenceField,
  ReferenceArrayField,
  SingleFieldList,
  DateField,
  BooleanField,
  EditButton,
  ShowButton,
  ImageField,
} from "react-admin";

import CustomTextField from "../components/CustomTextField";
// import ThumbnailField from "../components/ThumbnailField";

const AlbumsList = (props) => (
  <List {...props}>
    <Datagrid rowClick="edit">
      <TextField source="id" />
      <ReferenceArrayField
        label="Covers"
        source="covers"
        reference="media_objects"
      >
        <SingleFieldList>
          <ImageField source="thumbnailContentUrl" title="" />
        </SingleFieldList>
      </ReferenceArrayField>
      <TextField source="title" />
      <ReferenceField label="Artist" source="artist" reference="artists">
        <CustomTextField source="name" />
      </ReferenceField>
      <DateField source={"date"} label="Year" options={{ year: "numeric" }} />
      <BooleanField source={"active"} />
      <DateField source={"created_date"} locales="fr-FR" />
      <EditButton />
      <ShowButton />
    </Datagrid>
  </List>
);

export default AlbumsList;
