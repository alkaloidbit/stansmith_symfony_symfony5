// in profile.js
import React, { useCallback, useMemo, useState } from 'react';
import { SaveContextProvider, useDataProvider, useRefresh, useNotify, useGetIdentity } from 'react-admin';
import { FileInput, TextInput, SimpleForm, required } from 'react-admin';

export const ProfileEdit = ({ staticContext, ...props }) => {
  const dataProvider = useDataProvider();
  const notify = useNotify();
  const refresh = useRefresh();
  const [saving, setSaving] = useState();

  const { identity, isLoading, error} = useGetIdentity();

  const handleSave = useCallback((values) => {
    setSaving(true);
    dataProvider.updateUserProfile(
      { data: values },
      {
        onSuccess: ({ data }) => {
          setSaving(false);
          notify("Your profile has been updated", "info", {
            _: "Your profile has been updated"
          });
        },
        onFailure: () => {
          setSaving(false);
          notify(
            "A technical error occured while updating your profile. Please try later.",
            "warning",
            {
              _:
                "A technical error occured while updating your profile. Please try later."
            }
          );
        }
      }
    );
  }, [dataProvider, notify, refresh]);

  const saveContext = useMemo(() => ({
    save: handleSave,
    saving
  }), [saving, handleSave]);


  return (
    <SaveContextProvider value={saveContext}>
      <SimpleForm save={handleSave} record={identity ? identity : {}}>
        <TextInput source="fullName" validate={required()} />
        <FileInput source="avatar" validate={required()} />
      </SimpleForm>
    </SaveContextProvider>
  );
};
