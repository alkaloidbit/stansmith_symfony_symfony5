<template>
    <router-view />
</template>

<script >
import axios from 'axios';

export default {
    name: 'App',
    created() {
        // Server response: isAuthenticated && User
        const isAuthenticated = JSON.parse(this.$parent.$el.attributes['data-is-authenticated'].value);
        // User from server
        const user = JSON.parse(this.$parent.$el.attributes['data-user'].value);

        const payload = { isAuthenticated, user };
        //  Updating states
        this.$store.dispatch('security/onRefresh', payload);

        axios.interceptors.request.use((req) => {
            console.log(`Request ${req.method} ${req.url}`);
            return req;
        });

        axios.interceptors.response.use(
            (res) => {
                console.log('Response.data:', res.data);
                return res;
            },
            (err) => {
                if (err.response.status === 401) {
                    if (this.$route.path !== '/login') {
                        this.$router.push({ path: '/login' });
                    }
                } else if (err.response.status === 500) {
                    document.open();
                    document.write(err.response.data);
                    document.close();
                }
                throw err;
            },
        );
    },
};
</script>
