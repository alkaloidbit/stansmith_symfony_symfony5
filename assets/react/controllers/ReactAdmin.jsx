import {
  HydraAdmin,
  hydraDataProvider as baseHydraDataProvider,
  fetchHydra as baseFetchHydra
} from "@api-platform/admin";
import React from 'react';
import { Redirect, Route } from "react-router-dom";
import {
  fetchUtils,
  Login,
  Resource
} from "react-admin";
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
// import MyLoginPage from "../admin/login.js";
import MyLoginPage from "../admin/MyLoginPage";

const entrypoint = 'http://localhost:8000/api';
const fetchHeaders = {};
const fetchHydra = (url, options = { credentials: "include" }) => {
  return baseFetchHydra(url, {
    ...options,
    options: { credentials: "include" },
    headers: new Headers(fetchHeaders)
  });
};

const apiDocumentationParser = entrypoint =>
  parseHydraDocumentation(entrypoint, {
    headers: new Headers(fetchHeaders)
  }).then(
        ({ api }) => ({ api }),
        (result) => {
            switch (result.status) {
                case 401:
                    return Promise.resolve({
                        api: result.api,
                        customRoutes: [
                            <Route path="/" render={() => {
                                return window.localStorage.getItem("loggedIn") ? window.location.reload() : <Redirect to="/login" />
                            }} />
                        ],
                    });
                default:
                    return Promise.reject(result);
            }
        }
    );

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

