import { HydraAdmin, ResourceGuesser } from '@api-platform/admin';
const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;
const App = () => (
    <HydraAdmin entrypoint={entrypoint} />
);

export default App;
