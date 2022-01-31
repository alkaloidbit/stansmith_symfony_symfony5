import { 
    HydraAdmin,
    fetchHydra,
    hydraDataProvider,
    ListGuesser,
    ResourceGuesser,
    FieldGuesser
} from '@api-platform/admin';

import { 
    Resource, 
    ReferenceField,
    EditButton 
} from "react-admin";

import { parseHydraDocumentation } from '@api-platform/api-doc-parser';

import ThumbnailFieldAlt from './ThumbnailField_alt';
import CustomTextField from './CustomTextField';

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
        <ReferenceField label="Cover" source="mainThumbnail" reference="thumbnail_objects">
            <ThumbnailFieldAlt source="contentUrl" />
        </ReferenceField>
        <FieldGuesser source="title" />
        <FieldGuesser source="date" />
        <ReferenceField label="Artist" source="artist" reference="artists">
            <CustomTextField source="name" />
        </ReferenceField>
        <EditButton />
    </ListGuesser>
};

const App = () => (
    <HydraAdmin dataProvider={dataProvider} entrypoint={entrypoint}>
        <ResourceGuesser name="albums" list={AlbumsList} />
        <ResourceGuesser name="artists" />
        <Resource name="thumbnail_objects" />
    </HydraAdmin>
);

export default App;
