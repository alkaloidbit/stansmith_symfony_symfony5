import { 
    HydraAdmin,
    fetchHydra,
    hydraDataProvider,
    ResourceGuesser,
} from '@api-platform/admin';
import { parseHydraDocumentation } from '@api-platform/api-doc-parser';
import { Resource, EditGuesser } from 'react-admin';
import AlbumIcon from '@material-ui/icons/AlbumTwoTone';
import ArtistIcon from '@material-ui/icons/PersonOutlineTwoTone';
import ImageIcon from '@material-ui/icons/ImageTwoTone';
import AudioTrackIcon from '@material-ui/icons/AudiotrackTwoTone';
import { AlbumsList, AlbumCreate, AlbumEdit, AlbumShow } from './albums';
import { ArtistsList, ArtistsEdit } from './artists';
import { TracksList } from './tracks';
import { MediaObjectsList, MediaObjectCreate, MediaObjectEdit } from './media_objects';

const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;

const dataProvider = hydraDataProvider({
    entrypoint,
    httpClient: fetchHydra,
    apiDocumentationParser: parseHydraDocumentation,
    mercure: true,
    useEmbedded: false,
});

const App =  () => (
    <HydraAdmin 
        dataProvider={dataProvider}
        entrypoint={entrypoint}>
        <Resource name="artists" list={ArtistsList} edit={ArtistsEdit} icon={ArtistIcon}/>
        <Resource name="albums" create={AlbumCreate} list={AlbumsList} show={AlbumShow} edit={AlbumEdit} icon={AlbumIcon} />
        <Resource name="thumbnail_objects" />
        <Resource name="media_objects" edit={MediaObjectEdit} list={MediaObjectsList} create={MediaObjectCreate} icon={ImageIcon} />
        <Resource name="tracks" list={TracksList} icon={AudioTrackIcon}/>
    </HydraAdmin>
);

export default App;
