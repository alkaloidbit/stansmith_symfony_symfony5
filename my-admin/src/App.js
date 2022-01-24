import { 
    HydraAdmin,
    fetchHydra,
    ListGuesser,
    hydraDataProvider
} from '@api-platform/admin';

import { parseHydraDocumentation } from '@api-platform/api-doc-parser';

import { Resource } from 'react-admin';
import AlbumIcon from '@material-ui/icons/Album';
import { AlbumsList } from './albums';

const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;

const dataProvider = hydraDataProvider({
    entrypoint,
    httpClient: fetchHydra,
    apiDocumentationParser: parseHydraDocumentation,
    mercure: true,
    useEmbedded: true,
});

export default () => (
    <HydraAdmin 
        dataProvider={dataProvider}
        entrypoint={entrypoint}>
        <Resource name="albums" list={AlbumsList} icon={AlbumIcon} />
    </HydraAdmin>
);
