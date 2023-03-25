import * as React from "react";
import {
  Datagrid,
  TextField,
  DateField,
  BooleanField,
  ShowButton,
  Show,
  TabbedShowLayout,
  Tab,
  ReferenceArrayField
} from "react-admin";
import ThumbnailField from "../components/ThumbnailField";
import AddMediaObjectButton from "../components/AddMediaObjectButton";

const AlbumShow = props => (
  <Show {...props}>
    <TabbedShowLayout>
      <Tab label="Summary">
        <TextField source="id" />
        <TextField source="title" />
        <DateField source="date" />
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
            <ThumbnailField source="coverContentUrl" />
            <DateField source="created_date" />
            <ShowButton />
          </Datagrid>
        </ReferenceArrayField>
        <AddMediaObjectButton />
      </Tab>
    </TabbedShowLayout>
  </Show>
);

export default AlbumShow;
