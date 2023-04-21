import {
  hydraDataProvider as baseHydraDataProvider,
  fetchHydra as baseFetchHydra,
} from "@api-platform/admin";
import { parseHydraDocumentation } from "@api-platform/api-doc-parser";

const fetchHeaders = {};
const fetchHydra = (url, options = { credentials: "include" }) => {
  return baseFetchHydra(url, {
    ...options,
    options: { credentials: "include" },
    headers: new Headers(fetchHeaders),
  });
};

const entrypoint = "http://localhost:8000/api";
const dataProvider = baseHydraDataProvider({
  entrypoint,
  fetchHydra,
  apiDocumentationParser: parseHydraDocumentation,
  mercure: true,
  useEmbedded: false,
});

export default dataProvider;
