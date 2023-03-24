// in src/authProvider.js
const authProvider = {
    login: ({ email, password }) =>  {
        const request = new Request('/api/security/login', {
            method: 'POST',
            body: JSON.stringify({ email, password }),
            credentials: 'include',
            headers: new Headers({ 'Content-Type': 'application/json' })
        });
        return fetch(request)
            .then(response => {
                if (response.status < 200 || response.status >= 300) {
                    throw new Error(response.statusText);
                }
                localStorage.setItem('userIri', response.headers.get('Location'));
                return Promise.resolve();
            })
            .catch(() => {
                throw new Error('Network error')
            });
    },
    checkAuth: () => {
        // Required for the authentication to work
        return Promise.resolve();
    },
    getIdentity: () => {
        try {
            const userIri = localStorage.getItem('userIri');
            return fetch(userIri)
            .then(response => {
                return response.json();
            })
            .then(json => {
                const { username } = json;
                const fullName = username;
                const id = json['@id'];
                return Promise.resolve({ fullName, id });
            })
            .catch(()=> {
                throw new Error('Network error');
            });
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
