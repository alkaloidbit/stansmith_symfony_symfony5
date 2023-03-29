import {
  HydraAdmin,
  hydraDataProvider as baseHydraDataProvider,
  fetchHydra as baseFetchHydra
} from "@api-platform/admin";
import React from 'react';
import { Resource } from "react-admin";
import { parseHydraDocumentation } from "@api-platform/api-doc-parser";
import { PersonTwoTone } from "@material-ui/icons";
import { AlbumTwoTone } from "@material-ui/icons";
import { ImageTwoTone } from "@material-ui/icons";
import { MusicNoteTwoTone } from "@material-ui/icons";
import media_objects from "../admin/media_objects";
import artists from "../admin/artists";
import albums from "../admin/albums";
import tracks from "../admin/tracks";
import authProvider from "../admin/authProvider";
// import MyLoginPage from "../admin/login";
import MyLoginPage from "../admin/SignIn";
import MyLogoutButton from "../admin/MyLogoutButton";

const entrypoint = 'http://localhost:8000/api';
const fetchHeaders = {};
const fetchHydra = (url, options = { credentials: "include" }) => {
  return baseFetchHydra(url, {
    ...options,
    options: { credentials: "include" },
    headers: new Headers(fetchHeaders)
  });
};

const dataProvider = baseHydraDataProvider({
  entrypoint,
  fetchHydra,
  apiDocumentationParser: parseHydraDocumentation,
  mercure: true,
  useEmbedded: false
});

export default () => (
  <HydraAdmin
    loginPage={MyLoginPage}
    logoutButton={MyLogoutButton}
    authProvider={authProvider}
    dataProvider={dataProvider}
    entrypoint={entrypoint}
  >
    <Resource name="media_objects" {...media_objects} icon={ImageTwoTone} />
    <Resource name="artists" {...artists} icon={PersonTwoTone} />
    <Resource name="albums" {...albums} icon={AlbumTwoTone} />
    <Resource name="tracks" {...tracks} icon={MusicNoteTwoTone} />
  </HydraAdmin>
);

