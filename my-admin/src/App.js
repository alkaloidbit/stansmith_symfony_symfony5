import { HydraAdmin, fetchHydra, hydraDataProvider } from '@api-platform/admin';
import { Resource } from 'react-admin';
import { parseHydraDocumentation } from '@api-platform/api-doc-parser';
import { PersonTwoTone } from '@material-ui/icons';
import { AlbumTwoTone } from '@material-ui/icons';
import { ImageTwoTone } from '@material-ui/icons';
import { MusicNoteTwoTone } from '@material-ui/icons';
import media_objects from './media_objects';
import artists from './artists';
import albums from './albums';
import tracks from './tracks';

const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;

const dataProvider = hydraDataProvider({
    entrypoint,
    httpClient: fetchHydra,
    apiDocumentationParser: parseHydraDocumentation,
    mercure: true,
    useEmbedded: false,
});

const App = () => (
    <HydraAdmin 
        dataProvider={dataProvider}
        entrypoint={entrypoint} 
    >
        <Resource name="media_objects" {...media_objects} icon={ImageTwoTone} />
        <Resource name="artists" {...artists} icon={PersonTwoTone}/>
        <Resource name="albums" {...albums} icon={AlbumTwoTone} />
        <Resource name="tracks" {...tracks} icon={MusicNoteTwoTone} />
    </HydraAdmin>
);

export default App;
