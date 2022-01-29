import { 
    HydraAdmin,
    fetchHydra,
    hydraDataProvider,
    ListGuesser,
    ResourceGuesser,
    FieldGuesser
} from '@api-platform/admin';

import { ReferenceField, ReferenceManyField, TextField, SingleFieldList, ChipField } from "react-admin";

import { parseHydraDocumentation } from '@api-platform/api-doc-parser';

const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;

const dataProvider = hydraDataProvider({
    entrypoint,
    httpClient: fetchHydra,
    apiDocumentationParser: parseHydraDocumentation,
    mercure: true,
    useEmbedded: false,
});

const AlbumsList = (props) => {
    return <ListGuesser {...props}>
        <ReferenceManyField label="Cover" reference="thumbnail_objects" target="album_id">
            <SingleFieldList>
                <ChipField source="fileName" />
            </SingleFieldList>
        </ReferenceManyField>
        <FieldGuesser source="title" />
        <FieldGuesser source="date" />
        <ReferenceField label="Artist" source="artist" reference="artists">
            <TextField source="name" />
        </ReferenceField>
    </ListGuesser>
};

const App = () => (
    <HydraAdmin dataProvider={dataProvider} entrypoint={entrypoint}>
        <ResourceGuesser name="albums" list={AlbumsList} />
        <ResourceGuesser name="artists" />
        <ResourceGuesser name="thumbnail_objects" />
    </HydraAdmin>
);

export default App;
