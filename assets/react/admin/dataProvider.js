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

// A function decorating a dataProvider for handling user profiles
const addUserProfileOverrides = (dataProvider) => ({
  ...dataProvider,
  getUserProfile(params) {
    const storedProfile = localStorage.getItem("userIri");

    console.log(storedProfile);
    if (storedProfile) {
      return Promise.resolve({
        data: JSON.parse(storedProfile),
      });
    }

    // No profile yet, return a default one
    return Promise.resolve({
      data: {
        // As we are only storing this information in the localstorage, we don't really care about this id
        id: "unique-id",
        fullName: "",
        avatar: "",
      },
    });
  },

  updateUserProfile(params) {
    localStorage.setItem(
      "profile",
      JSON.stringify({ id: "unique-id", ...params.data })
    );
    return Promise.resolve({ data: params.data });
  },
});

export default addUserProfileOverrides(dataProvider);
