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
  useRecordContext,
  useDataProvider,
} from "react-admin";
import { useMutation } from "react-query";

const MediaObjectCreate = (props) => {
  const location = useLocation();
  const notify = useNotify();
  const redirect = useRedirect();
  const refresh = useRefresh();

  const record = location.state.record;

  const album_id =
    location.state && location.state.record
      ? location.state.record["@id"]
      : undefined;

  const albumResourceRedirectURI = album_id
    ? `/albums/${encodeURIComponent(album_id)}/show/media_objects`
    : false;

  const sendRequest = (url, method, body) => {
    const options = {
      method: method,
      headers: new Headers({ "content-type": "application/json" }),
    };

    options.body = JSON.stringify(body);

    return fetch(url, options);
  };
  // on MediaObject creation success
  const onSuccess = ( data ) => {
    // New mediaObject uri
    const newCoverURI = data["@id"];
    const updatedRecord = {
      ...record,
      covers: [...record.covers, newCoverURI],
    };

    // Update album resource with new cover
    sendRequest(album_id, "PUT", updatedRecord)
      .then((data) => {
        notify("Album updated");
        redirect(albumResourceRedirectURI);
      })
      .catch((e) => {
        notify("Error: album not updated", { type: "warning" });
      });
  };

  return (
    <Create {...props} mutationOptions={{onSuccess}}>
      <SimpleForm addlabel="false">
        <ImageInput source="file" accept="image/*">
          <ImageField source="src" title="" />
        </ImageInput>
      </SimpleForm>
    </Create>
  );
};

export default MediaObjectCreate;
