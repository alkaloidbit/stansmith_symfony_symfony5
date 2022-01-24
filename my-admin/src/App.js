import { HydraAdmin } from '@api-platform/admin';
const entrypoint = process.env.REACT_APP_ADMIN_ENTRYPOINT;
export default () => (
    <HydraAdmin entrypoint={entrypoint} />
);
