import * as React from "react";
import {
  Edit,
  SimpleForm,
  BooleanInput,
  ReferenceArrayInput,
  ReferenceArrayField,
  SingleFieldList,
  SelectArrayInput,
  TextInput,
  ImageField,
} from "react-admin";

import ThumbnailField from "../components/ThumbnailField";

const AlbumTitle = ({ record }) => {
  return <span>Album {record ? `"${record.title}"` : ""}</span>;
};

const AlbumEdit = props => (
  <Edit title={<AlbumTitle />} {...props}>
    <SimpleForm>
      <TextInput disabled source="id" />
      <TextInput source="title" />
      <TextInput source="date" />
      <ReferenceArrayField
        label="Covers"
        source="covers"
        reference="media_objects"
      >
        <SingleFieldList>
          <ImageField source="thumbnailContentUrl" title="" />
        </SingleFieldList>
      </ReferenceArrayField>
      <ReferenceArrayInput source="covers" reference="media_objects">
        <SelectArrayInput optionText="@id" />
      </ReferenceArrayInput>
      <BooleanInput source="active" />
    </SimpleForm>
  </Edit>
);

export default AlbumEdit;
