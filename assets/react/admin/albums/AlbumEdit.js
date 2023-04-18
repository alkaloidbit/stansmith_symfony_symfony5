import * as React from "react";
import {
  Edit,
  TabbedForm,
  FormTab,
  BooleanInput,
  ReferenceArrayField,
  SingleFieldList,
  TextInput,
  ImageField,
  useRecordContext,
} from "react-admin";

import AddMediaObjectButton from "../components/AddMediaObjectButton";

const AlbumTitle = () => {
  const record =  useRecordContext();
  return <span>Album {record ? `"${record.title}"` : ""}</span>;
};

const AlbumEdit = (props) => (
  <Edit title={<AlbumTitle />} {...props}>
    <TabbedForm>
      <FormTab label="summary">
        <TextInput disabled source="id" />
        <TextInput source="title" />
        <TextInput source="date" />
        <BooleanInput source="active" />
      </FormTab>
      <FormTab label="Covers">
        <ReferenceArrayField
          label="Covers"
          source="covers"
          reference="media_objects"
        >
          <SingleFieldList>
            <ImageField source="coverContentUrl" title="" />
          </SingleFieldList>
        </ReferenceArrayField>
        <AddMediaObjectButton />
      </FormTab>
    </TabbedForm>
  </Edit>
);

export default AlbumEdit;
