// in src/authProvider.js
const authProvider = {
    login: async ({ email, password }) =>  {
        const request = new Request('/api/security/login', {
            method: 'POST',
            body: JSON.stringify({ email, password }),
            credentials: 'include',
            headers: new Headers({ 'Content-Type': 'application/json' })
        });
        try {
            const response = await fetch(request);
            if (response.status < 200 || response.status >= 300) {
                throw new Error(response.statusText);
            }
            localStorage.setItem('userIri', response.headers.get('Location'));
            return await Promise.resolve();
        } catch {
            throw new Error('Network error');
        }
    },
    checkAuth: () => {
        // Required for the authentication to work
        return Promise.resolve();
    },
    getIdentity: async () => {
        try {
            const userIri = localStorage.getItem('userIri');
            try {
                const response = await fetch(userIri);
                const json = await response.json();
                const { username } = json;
                const fullName = username;
                const id = json['@id'];
                return await Promise.resolve({ fullName, id });
            } catch {
                throw new Error('Network error');
            }
        } catch (error) {
            return Promise.reject(error);
        }
    },
    getPermissions: () => {
        // Required for the authentication to work
        return Promise.resolve();
    },
    checkError: (error) => {
        const status = error.response.status;
        if (status === 401 || status === 403) {
            return Promise.reject();
        }
        // other error code (404, 500, etc): no need to log out
        return Promise.resolve();
    },
    logout: async () => {
        const request = new Request('/api/security/logout', {
            method: 'POST',
        });
        try {
            const response = await fetch(request);
            if (response.status < 200 || response.status >= 300) {
                throw new Error(response.statusText);
            }
            localStorage.removeItem('userIri');
            return await Promise.resolve();
        } catch {
            throw new Error('Network error');
        }
    },
    // ...
};

export default authProvider;
