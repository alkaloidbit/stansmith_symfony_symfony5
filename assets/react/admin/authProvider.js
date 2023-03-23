// in src/authProvider.js
const authProvider = {
    login: ({ email, password }) =>  {
        const request = new Request('http://localhost:8000/api/security/login', {
            method: 'POST',
            body: JSON.stringify({ email, password }),
            credentials: 'include',
            headers: new Headers({ 'Content-Type': 'application/json' })
        });
        return fetch(request)
            .then(response => {
                // console.log(response.headers.get('Location'));
                console.log(response);
                if (response.status < 200 || response.status >= 300) {
                    throw new Error(response.statusText);
                }
                return response.body;
            })
            .then(body => {
                console.log(body.getReader());
            })
            .catch(() => {
                throw new Error('Network error')
            });
    },
    checkAuth: () => {
        // Required for the authentication to work
        return Promise.resolve();
    },
    getPermissions: () => {
        // Required for the authentication to work
        return Promise.resolve();
    },
    checkError: (error) => {
        const status = error.status;
        if (status === 401 || status === 403) {
            return Promise.reject();
        }
        // other error code (404, 500, etc): no need to log out
        return Promise.resolve();
    },
    logout: () => {
        const request = new Request('http://localhost:8000/api/security/logout', {
            method: 'GET',
            headers: new Headers({ 'Content-Type': 'application/json' })
        });
        return fetch(request)
        .then(response => {
            console.log(response);
        });
    },
    // ...
};

export default authProvider;
