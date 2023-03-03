import {
  HydraAdmin,
  hydraDataProvider as baseHydraDataProvider,
  fetchHydra as baseFetchHydra
} from "@api-platform/admin";
import { Redirect, Route } from "react-router-dom";
import { fetchUtils, Resource } from "react-admin";
import { parseHydraDocumentation } from "@api-platform/api-doc-parser";
import { PersonTwoTone } from "@material-ui/icons";
import { AlbumTwoTone } from "@material-ui/icons";
import { ImageTwoTone } from "@material-ui/icons";
import { MusicNoteTwoTone } from "@material-ui/icons";
import media_objects from "./media_objects";
import artists from "./artists";
import albums from "./albums";
import tracks from "./tracks";
import authProvider from "./authProvider";
import MyLoginPage from "./MyLoginPage.js";

const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;
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

const App = () => (
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

export default App;
