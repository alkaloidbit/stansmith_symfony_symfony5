import React from 'react';
import { Resource } from "react-admin";
import { Route } from 'react-router';
import { HydraAdmin } from '@api-platform/admin';

import { PersonTwoTone } from "@mui/icons-material";
import { AlbumTwoTone } from "@mui/icons-material";
import { ImageTwoTone } from "@mui/icons-material";
import { MusicNoteTwoTone } from "@mui/icons-material";

import media_objects from "../admin/media_objects";
import artists from "../admin/artists";
import albums from "../admin/albums";
import tracks from "../admin/tracks";

import MyLoginPage from "../admin/SignIn";
import MyLogoutButton from "../admin/MyLogoutButton";
import { MyLayout } from "../admin/MyLayout";
import Dashboard from "../admin/Dashboard";
import { ProfileEdit } from "../admin/profile";

import dataProvider from '../admin/dataProvider';
import authProvider from "../admin/authProvider";
const entrypoint = 'http://localhost:8000/api';

export default () => (
  <HydraAdmin
    dashboard={Dashboard}
    loginPage={MyLoginPage}
    logoutButton={MyLogoutButton}
    authProvider={authProvider}
    dataProvider={dataProvider}
    layout={MyLayout}
    entrypoint={entrypoint}
    customRoutes={[
      <Route
        key="my-profile"
        path="/my-profile"
        component={ProfileEdit}
      />
    ]}
  >
    <Resource name="media_objects" {...media_objects} icon={ImageTwoTone} />
    <Resource name="artists" {...artists} icon={PersonTwoTone} />
    <Resource name="albums" {...albums} icon={AlbumTwoTone} />
    <Resource name="tracks" {...tracks} icon={MusicNoteTwoTone} />
  </HydraAdmin>
);

