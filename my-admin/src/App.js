import { HydraAdmin, fetchHydra, hydraDataProvider } from '@api-platform/admin';
import { parseHydraDocumentation } from '@api-platform/api-doc-parser';
const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;

const dataProvider = hydraDataProvider({
    entrypoint,
    httpClient: fetchHydra,
    apiDocumentationParser: parseHydraDocumentation,
    mercure: true,
    useEmbedded: true,
});

const App = () => (
    <HydraAdmin 
        dataProvider={dataProvider}
        entrypoint={entrypoint} 
    />
);

export default App;
