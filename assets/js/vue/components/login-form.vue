<template>
    <form @submit.prevent="handleSubmit">
        <div
            v-if="error"
            class="alert alert-danger"
        >
            {{ error }}
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email Address</label>
            <input
                id="exampleInputEmail1"
                v-model="email"
                type="email"
                class="form-control"
                aria-describedby="emailHelp"
                placeholder="Enter email"
            >
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input
                id="exampleInputPassword1"
                v-model="password"
                type="password"
                class="form-control"
                placeholder="Password"
            >
        </div>
        <div class="form-check">
            <input
                id="exampleCheck1"
                class="form-check-input"
                type="checkbox"
            >
            <label
                class="form-check-label"
                for="exampleCheck1"
            >I like Cheese</label>
        </div>
        <button
            class="btn btn-primary"
            type="submit"
            :class="{ disabled: isLoading }"
        >
            Log in
        </button>
    </form>
</template>

<script>
import axios from 'axios';

export default {
    props: ['user'],
    data() {
        return {
            email: '',
            password: '',
            error: '',
            isLoading: false,
        };
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;
            this.error = '';

            axios
                .post('/api/security/login', {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    /** response.headers.location contains authenticated user uri*/
                    // console.log(response.headers.location);
                    console.log(response.data);
                    // this.$emit('user-authenticated', response.headers.location);

                    // this.email = '';
                    // this.password = '';
                }).catch((error) => {
                    if (error.response.data.error) {
                        this.error = error.response.data.error;
                    } else {
                        this.error = 'Unknown error';
                    }
                }).finally(() => {
                    this.isLoading = false;
                });
        },
    },
};
</script>
<style scoped lang="scss">

</style>
