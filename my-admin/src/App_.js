import { 
    HydraAdmin,
    fetchHydra,
    hydraDataProvider
} from '@api-platform/admin';
import { parseHydraDocumentation } from '@api-platform/api-doc-parser';
import { Resource, EditGuesser } from 'react-admin';
import AlbumIcon from '@material-ui/icons/AlbumTwoTone';
import ArtistIcon from '@material-ui/icons/PersonSharp';
import { AlbumsList, AlbumEdit } from './albums';
import { ArtistsList } from './artists'

const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;

const dataProvider = hydraDataProvider({
    entrypoint,
    httpClient: fetchHydra,
    apiDocumentationParser: parseHydraDocumentation,
    mercure: true,
    useEmbedded: true,
});

const App =  () => (
    <HydraAdmin 
        dataProvider={dataProvider}
        entrypoint={entrypoint}>
        <Resource name="artists" list={ArtistsList} icon={ArtistIcon}/>
        <Resource name="albums" list={AlbumsList} edit={AlbumEdit} icon={AlbumIcon} />
    </HydraAdmin>
);

export default App;
