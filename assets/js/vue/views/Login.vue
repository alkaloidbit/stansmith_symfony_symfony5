<template>
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-two-fifths ">
                        <div class="card">
                            <div
                                v-if="hasError"
                            >
                                <error-message :error="error" />
                            </div>
                            <div class="card-content">
                                <form>
                                    <div class="field">
                                        <label class="label">E-mail Address</label>
                                        <div class="control is-clearfix">
                                            <input
                                                v-model="login"
                                                type="email"
                                                placeholder="Your Email"
                                                class="input"
                                                autocomplete="on"
                                                autofocus
                                            >
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control is-clearfix">
                                            <input
                                                v-model="password"
                                                type="password"
                                                autocomplete="on"
                                                class="input"
                                            >
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label
                                            class="checkbox is-thin"
                                            for=""
                                        >
                                            <input
                                                type="checkbox"
                                                true-value="true"
                                                value="false"
                                            >
                                            <span class="check is-primary" />
                                            <span class="control-label">Remember me</span>
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="field">
                                        <div class="field-body">
                                            <div class="field is-grouped">
                                                <div class="control">
                                                    <button
                                                        :disabled="login.length === 0
                                                            || password.length === 0 || isLoading"
                                                        type="button"
                                                        class="button is-primary"
                                                        :class="{ 'is-loading': isLoading }"
                                                        @click="performLogin()"
                                                    >
                                                        <span>Login</span>
                                                    </button>
                                                </div>
                                                <div class="control">
                                                    <button
                                                        type="button"
                                                        class="button is-outlined"
                                                    >
                                                        <span>Forgot Password?</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ErrorMessage from '../components/ErrorMessage';

export default {
    name: 'Login',
    components: {
        ErrorMessage,
    },
    data() {
        return {
            login: '',
            password: '',
        };
    },
    computed: {
        isLoading() {
            return this.$store.getters['security/isLoading'];
        },
        hasError() {
            return this.$store.getters['security/hasError'];
        },
        error() {
            return this.$store.getters['security/error'];
        },
    },
    created() {
        const { redirect } = this.$route.query;

        if (this.$store.getters['security/isAuthenticated']) {
            if (typeof redirect !== 'undefined') {
                this.$router.push({ path: redirect });
            } else {
                this.$router.push({ path: '/login' });
            }
        }
    },
    methods: {
        async performLogin() {
            // getting login info from form
            const payload = { login: this.$data.login, password: this.$data.password };
            const { redirect } = this.$route.query;

            // dispatch login action, passing payload
            await this.$store.dispatch('security/login', payload);

            if (!this.$store.getters['security/hasError']) {
                if (typeof redirect !== 'undefined') {
                    this.$router.push({ path: redirect });
                } else {
                    this.$router.push({ path: '/home' });
                }
            }
        },
    },
};
</script>

<style lang="scss">
.box {
    margin-top: 5rem;
}

.card .card-content hr {
    margin-left: -1.5rem;
    margin-right: -1.5rem;
}
.hero.is-success {
    background: #F2F6FA;
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
    border: 1px solid;
    -webkit-box-shadow: 0 0 0px 1000px #FFF inset;
    box-shadow: 0 0 0px 1000px #FFF inset;
}

.avatar {
    margin-top: -70px;
    padding-bottom: 20px;
    img {
        padding: 5px;
        background: #FFF;
        border-radius: 50%;
        box-shadow: 0 2px 3px rgba(10,10,10, .1), 0 0 0 1px rgba(10,10,10,.1);
    }
}

</style>
