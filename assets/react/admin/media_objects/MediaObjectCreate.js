import React from "react";
import { useLocation } from "react-router";
import {
  Create,
  SimpleForm,
  ImageInput,
  ImageField,
  useNotify,
  useRedirect,
  useRefresh,
} from "react-admin";

const MediaObjectCreate = (props) => {
  const location = useLocation();
  const notify = useNotify();
  const redirect = useRedirect();
  const refresh = useRefresh();

  console.log("record", location.state.record);
  console.log("covers", location.state.record.covers);

  const album_id =
    location.state && location.state.record
      ? location.state.record["@id"]
      : undefined;

  console.log("album_id", album_id);

  const albumResourceRedirectURI = album_id
    ? `/albums/${encodeURIComponent(album_id)}/show/media_objects`
    : false;

  console.log("redirect", albumResourceRedirectURI);

  // on MediaObject creation success
  const onSuccess = ({ data }) => {
    console.log(data);
    redirect(albumResourceRedirectURI);
  };

  return (
    <Create {...props} mutationMode="pessimistic" onSuccess={onSuccess}>
      <SimpleForm addlabel="false">
        <ImageInput source="file" accept="image/*">
          <ImageField source="src" title="" />
        </ImageInput>
      </SimpleForm>
    </Create>
  );
};

export default MediaObjectCreate;
